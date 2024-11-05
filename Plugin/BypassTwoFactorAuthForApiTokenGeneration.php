<?php
declare(strict_types=1);

namespace MarkShust\DisableTwoFactorAuth\Plugin;

use Closure;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Integration\Api\AdminTokenServiceInterface;
use Magento\TwoFactorAuth\Model\AdminAccessTokenService;

/**
 * Class BypassWebApiTwoFactorAuth
 * @package MarkShust\DisableTwoFactorAuth\Plugin
 */
class BypassTwoFactorAuthForApiTokenGeneration
{
    /** @var AdminTokenServiceInterface */
    private $adminTokenService;

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /** @var State */
    private $appState;

    /**
     * BypassTwoFactorAuthForApiTokenGeneration constructor.
     * @param AdminTokenServiceInterface $adminTokenService
     * @param ScopeConfigInterface $scopeConfig
     * @param State $appState
     */
    public function __construct(
        AdminTokenServiceInterface $adminTokenService,
        ScopeConfigInterface $scopeConfig,
        State $appState
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->adminTokenService = $adminTokenService;
        $this->appState = $appState;
    }

    /**
     * Enables the bypass of 2FA for API token generation.
     * This can be useful for within development & integration environments.
     *
     * If 2FA is enabled, return the original result.
     * If developer mode is enabled, 2FA is disabled unless "Disable 2FA in developer mode" is set to No.
     *
     * Calling createAdminAccessToken within this function bypasses 2FA.
     *
     * NOTE: Always keep 2FA enabled within production environments for security purposes.
     *
     * @param AdminAccessTokenService $subject
     * @param Closure $proceed
     * @param string $username
     * @param string $password
     * @return string
     * @throws AuthenticationException
     * @throws InputException
     * @throws LocalizedException
     */
    public function aroundCreateAdminAccessToken(
        AdminAccessTokenService $subject,
        Closure $proceed,
        $username,
        $password
    ): string {
        $isMain2faEnabled = $this->scopeConfig->isSetFlag(
            BypassTwoFactorAuth::XML_PATH_CONFIG_ENABLE
        );
        $isApi2faEnabled = $this->scopeConfig->isSetFlag(
            BypassTwoFactorAuth::XML_PATH_CONFIG_ENABLE_FOR_API_TOKEN_GENERATION
        );
        $isDeveloperMode = $this->appState->getMode() == State::MODE_DEVELOPER;
        $alwaysDisableInDeveloperMode = $this->scopeConfig->isSetFlag(
            BypassTwoFactorAuth::XML_PATH_CONFIG_DISABLE_IN_DEVELOPER_MODE
        );

        if ($isDeveloperMode && $alwaysDisableInDeveloperMode) {
            $isMain2faEnabled = false;
            $isApi2faEnabled = false;
        }

        $is2faEnabled = $isMain2faEnabled && $isApi2faEnabled;

        return $is2faEnabled
            ? $proceed($username, $password)
            : $this->adminTokenService->createAdminAccessToken($username, $password);
    }
}
