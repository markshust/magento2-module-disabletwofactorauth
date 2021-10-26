<?php
declare(strict_types=1);

namespace MarkShust\DisableTwoFactorAuth\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;
use Magento\TwoFactorAuth\Model\TfaSession;

/**
 * Class BypassTwoFactorAuth
 * @package MarkShust\DisableTwoFactorAuth\Plugin
 */
class BypassTwoFactorAuth
{
    const XML_PATH_CONFIG_ENABLE = 'twofactorauth/general/enable';
    const XML_PATH_CONFIG_DISABLE_DEV_2FA = 'twofactorauth/general/disable_developer_auth';

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /** @var State */
    private $appState;

    /**
     * BypassTwoFactorAuth constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param State $appState
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        State $appState
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->appState = $appState;
    }

    /**
     * Enables the bypass of 2FA for admin access.
     * This can be useful within development & integration environments.
     *
     * If 2FA is enabled, return the original result.
     * If 2FA is disabled, always return true so all requests bypass 2FA.
     * If 2FA is disabled only for developer mode, return true when in developer mode to bypass 2FA.
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
        // 2FA is always disabled.
        if (!$this->scopeConfig->isSetFlag(self::XML_PATH_CONFIG_ENABLE)) {
            return true;
        }

        // 2FA is disabled only for developer mode.
        if ($this->scopeConfig->isSetFlag(self::XML_PATH_CONFIG_DISABLE_DEV_2FA)
            && $this->appState->getMode() == State::MODE_DEVELOPER) {
            return true;
        }

        return $result;
    }
}
