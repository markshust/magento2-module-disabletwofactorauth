<?php

declare(strict_types=1);

namespace MarkShust\DisableTwoFactorAuth\Plugin;

use Closure;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Integration\Api\AdminTokenServiceInterface;
use Magento\TwoFactorAuth\Model\AdminAccessTokenService;
use MarkShust\DisableTwoFactorAuth\App\Config\TwoFactorAuthInterface;

/**
 * Class BypassWebApiTwoFactorAuth
 * @package MarkShust\DisableTwoFactorAuth\Plugin
 */
class BypassTwoFactorAuthForApiTokenGeneration
{

    /** @var AdminTokenServiceInterface */
    private $adminTokenService;

    /**
     * @var TwoFactorAuthInterface
     */
    private $twoFactorAuthConfig;

    /**
     * BypassTwoFactorAuthForApiTokenGeneration constructor.
     * @param AdminTokenServiceInterface $adminTokenService
     * @param TwoFactorAuthInterface $twoFactorAuthConfig
     */
    public function __construct(
        AdminTokenServiceInterface $adminTokenService,
        TwoFactorAuthInterface $twoFactorAuthConfig
    ) {
        $this->adminTokenService = $adminTokenService;
        $this->twoFactorAuthConfig = $twoFactorAuthConfig;
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
        return $this->twoFactorAuthConfig->isEnableApiTokenGeneration()
            ? $proceed($username, $password)
            : $this->adminTokenService->createAdminAccessToken($username, $password);
    }
}
