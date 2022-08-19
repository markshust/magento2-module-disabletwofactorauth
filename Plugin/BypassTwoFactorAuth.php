<?php
declare(strict_types=1);

namespace MarkShust\DisableTwoFactorAuth\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;
use Magento\TwoFactorAuth\Model\TfaSession;
use MarkShust\DisableTwoFactorAuth\Action\ShouldCurrentIpBypassTwoFactorAuth;

/**
 * Class BypassTwoFactorAuth
 * @package MarkShust\DisableTwoFactorAuth\Plugin
 */
class BypassTwoFactorAuth
{
    const XML_PATH_CONFIG_ENABLE = 'twofactorauth/general/enable';
    const XML_PATH_CONFIG_ENABLE_FOR_API_TOKEN_GENERATION = 'twofactorauth/general/enable_for_api_token_generation';
    const XML_PATH_CONFIG_DISABLE_IN_DEVELOPER_MODE = 'twofactorauth/general/disable_in_developer_mode';

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /** @var State */
    private $appState;

    /** @var ShouldCurrentIpBypassTwoFactorAuth  */
    private $shouldCurrentIpBypassTwoFactorAuth;

    /**
     * BypassTwoFactorAuth constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param State $appState
     * @param ShouldCurrentIpBypassTwoFactorAuth $shouldCurrentIpBypassTwoFactorAuth
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        State $appState,
        ShouldCurrentIpBypassTwoFactorAuth $shouldCurrentIpBypassTwoFactorAuth
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->appState = $appState;
        $this->shouldCurrentIpBypassTwoFactorAuth = $shouldCurrentIpBypassTwoFactorAuth;
    }

    /**
     * Enables the bypass of 2FA for admin access.
     * This can be useful for within development & integration environments.
     *
     * If 2FA is enabled, return the original result.
     * If developer mode is enabled, 2FA is disabled unless "Disable 2FA in developer mode" is set to No.
     *
     * Returning true in this function bypasses 2FA.
     *
     * NOTE: Always keep 2FA enabled within production environments for security purposes.
     *
     * @param TfaSession $subject
     * @param $result
     * @return bool
     */
    public function afterIsGranted(
        TfaSession $subject,
        $result
    ): bool {
        $is2faEnabled = $this->scopeConfig->isSetFlag(self::XML_PATH_CONFIG_ENABLE);
        $isDeveloperMode = $this->appState->getMode() == State::MODE_DEVELOPER;
        $alwaysDisableInDeveloperMode = $this->scopeConfig->isSetFlag(self::XML_PATH_CONFIG_DISABLE_IN_DEVELOPER_MODE);

        if (($isDeveloperMode && $alwaysDisableInDeveloperMode)
            || $this->shouldCurrentIpBypassTwoFactorAuth->execute()
        ) {
            $is2faEnabled = false;
        }

        return $is2faEnabled
            ? $result
            : true;
    }
}
