<?php

declare(strict_types=1);

namespace MarkShust\DisableTwoFactorAuth\Action;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;

use function array_filter;
use function explode;
use function in_array;

class ShouldCurrentIpBypassTwoFactorAuth
{
    const XML_PATH_CONFIG_DISABLE_FOR_IPS = 'twofactorauth/general/disable_for_ips';

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /** @var RemoteAddress */
    private $remoteAddress;

    public function __construct(ScopeConfigInterface $scopeConfig, RemoteAddress $remoteAddress)
    {
        $this->scopeConfig = $scopeConfig;
        $this->remoteAddress = $remoteAddress;
    }

    public function execute(): bool
    {
        $disableForIps = array_filter(
            explode(',' , (string)$this->scopeConfig->getValue(self::XML_PATH_CONFIG_DISABLE_FOR_IPS))
        );
        return in_array($this->remoteAddress->getRemoteAddress(), $disableForIps);
    }
}
