<?php

declare(strict_types=1);

namespace MarkShust\DisableTwoFactorAuth\Plugin;

use Magento\TwoFactorAuth\Model\TfaSession;
use MarkShust\DisableTwoFactorAuth\App\Config\TwoFactorAuthInterface;
use Magento\Backend\Model\Auth\Session as AuthSession;
use MarkShust\DisableTwoFactorAuth\App\Data\ModifierUserInterface;

/**
 * Class BypassTwoFactorAuthForWebsiteOrSomeUser
 * @package MarkShust\DisableTwoFactorAuth\Plugin
 */
class BypassTwoFactorAuthForWebsiteOrSomeUser
{
    /**
     * @var TwoFactorAuthInterface
     */
    private $twoFactorAuthConfig;

    /**
     * @var AuthSession
     */
    private $authSession;

    /**
     * BypassTwoFactorAuthForAdmins constructor.
     * @param TwoFactorAuthInterface $twoFactorAuthConfig
     * @param AuthSession $authSession
     */
    public function __construct(
        TwoFactorAuthInterface $twoFactorAuthConfig,
        AuthSession            $authSession
    ) {
        $this->twoFactorAuthConfig = $twoFactorAuthConfig;
        $this->authSession = $authSession;
    }

    /**
     * Enables the bypass of 2FA for admin access.
     * This can be useful within development & integration environments.
     *
     * If 2FA is enabled for user, return the original result.
     * If 2FA is disabled for user, always return true so all requests bypass 2FA.
     *
     * @param TfaSession $tfaSession
     * @param $isGranted
     * @return bool
     */
    public function afterIsGranted(TfaSession $tfaSession, $isGranted): bool
    {
        if (!$this->twoFactorAuthConfig->isEnable()) {
            return true;
        }
        if (!$this->isEnableAuthForCurrentUser()) {
            return true;
        }

        return $isGranted;
    }

    /**
     * @return bool
     */
    public function isEnableAuthForCurrentUser(): bool
    {
        return ($user = $this->authSession->getUser())
            ? (bool) $user->getData(ModifierUserInterface::IS_ENABLE_2FA_AUTH)
            : true;
    }
}
