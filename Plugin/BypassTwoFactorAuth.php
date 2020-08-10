<?php
declare(strict_types=1);

namespace MarkShust\DisableTwoFactorAuth\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\TwoFactorAuth\Model\TfaSession;

class BypassTwoFactorAuth
{
    /** @var ScopeConfigInterface */
    private $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * If the TwoFactorAuth module Enable setting is set to false, always return true here so all requests bypass 2FA.
     * Otherwise, return the original result.
     *
     * @param TfaSession $subject
     * @param $result
     * @return bool
     */
    public function afterIsGranted(TfaSession $subject, $result): bool
    {
        return !$this->scopeConfig->isSetFlag('twofactorauth/general/enable')
            ? true
            : $result;
    }
}
