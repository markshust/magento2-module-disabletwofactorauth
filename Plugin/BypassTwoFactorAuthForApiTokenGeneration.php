<?php

declare(strict_types=1);

namespace MarkShust\DisableTwoFactorAuth\Plugin;

use Closure;
use Magento\Framework\App\Config\ScopeConfigInterface;
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
    const XML_PATH_CONFIG_ENABLE_FOR_API_TOKEN_GENERATION = 'twofactorauth/general/enable_for_api_token_generation';

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /** @var AdminTokenServiceInterface */
    private $adminTokenService;

    /**
     * BypassTwoFactorAuthForApiTokenGeneration constructor.
     * @param AdminTokenServiceInterface $adminTokenService
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        AdminTokenServiceInterface $adminTokenService,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->adminTokenService = $adminTokenService;
    }

    /**
     * Enables the bypass of 2FA for API token generation.
     * This can be useful for third-party vendors during module development.
     *
     * NOTE: Always keep 2FA enabled within production environments for security purposes.
     *
     * @param AdminAccessTokenService $subject
     * @param Closure $proceed
     * @param $username
     * @param $password
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
        return $this->scopeConfig->isSetFlag(self::XML_PATH_CONFIG_ENABLE_FOR_API_TOKEN_GENERATION)
            ? $proceed($username, $password)
            : $this->adminTokenService->createAdminAccessToken($username, $password);
    }
}
