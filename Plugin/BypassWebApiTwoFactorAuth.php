<?php

/**
 * This file is part of the MarkShust DisableTwoFactorAuth package
 *
 * @author Jitheesh V O <jitheeshvo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */
declare(strict_types=1);

namespace MarkShust\DisableTwoFactorAuth\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Integration\Api\AdminTokenServiceInterface;
use Magento\TwoFactorAuth\Model\AdminAccessTokenService;

/**
 * Class BypassWebApiTwoFactorAuth
 *
 * @package MarkShust\DisableTwoFactorAuth\Plugin
 */
class BypassWebApiTwoFactorAuth
{
    const XML_PATH_CONFIG_API_ENABLE = 'twofactorauth/general/enable_api';

    /** @var ScopeConfigInterface */
    private $scopeConfig;
    /**
     * @var AdminTokenServiceInterface
     */
    private AdminTokenServiceInterface $adminTokenService;

    public function __construct(
        AdminTokenServiceInterface $adminTokenService,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->adminTokenService = $adminTokenService;
    }

    /**
     * This will bypass 2fa and allow us to use existing token generate end-point
     * Recommended to use this until third-party service is ready to configure 2fa
     *
     * @param AdminAccessTokenService $subject
     * @param \Closure                $proceed
     * @param                         $username
     * @param                         $password
     *
     * @return string
     * @throws \Magento\Framework\Exception\AuthenticationException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function aroundCreateAdminAccessToken(
        AdminAccessTokenService $subject,
        \Closure $proceed,
        $username,
        $password
    ): string {
        return !$this->scopeConfig->isSetFlag(self::XML_PATH_CONFIG_API_ENABLE)
            ? $this->adminTokenService->createAdminAccessToken($username, $password)
            : $proceed($username, $password);
    }
}
