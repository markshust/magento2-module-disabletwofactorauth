<?php

declare(strict_types=1);

namespace MarkShust\DisableTwoFactorAuth\Plugin;

use Magento\TwoFactorAuth\Model\TfaSession;
use MarkShust\DisableTwoFactorAuth\App\Config\TwoFactorAuthInterface;

/**
 * Class BypassTwoFactorAuth
 * @package MarkShust\DisableTwoFactorAuth\Plugin
 */
class BypassTwoFactorAuth
{
    /**
     * @var TwoFactorAuthInterface
     */
    private $twoFactorAuthConfig;

    /**
     * BypassTwoFactorAuth constructor.
     * @param TwoFactorAuthInterface $twoFactorAuthConfig
     */
    public function __construct(
        TwoFactorAuthInterface $twoFactorAuthConfig
    ) {
        $this->twoFactorAuthConfig = $twoFactorAuthConfig;
    }

    /**
     * Enables the bypass of 2FA for admin access.
     * This can be useful within development & integration environments.
     *
     * If 2FA is enabled, return the original result.
     * If 2FA is disabled, always return true so all requests bypass 2FA.
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
        return $this->twoFactorAuthConfig->isEnable()
            ? $result
            : true;
    }
}
