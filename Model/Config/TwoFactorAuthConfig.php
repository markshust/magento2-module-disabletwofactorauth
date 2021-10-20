<?php

declare(strict_types=1);

namespace MarkShust\DisableTwoFactorAuth\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use MarkShust\DisableTwoFactorAuth\App\Config\TwoFactorAuthInterface;

/**
 * Class TwoFactorAuthConfig
 * @package MarkShust\DisableTwoFactorAuth\Model\Config
 */
class TwoFactorAuthConfig implements TwoFactorAuthInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritDoc
     */
    public function isEnable(): bool
    {
        return (bool) $this->scopeConfig->isSetFlag(self::XML_CONFIG_PATH_ENABLE);
    }

    /**
     * @inheritDoc
     */
    public function isEnableApiTokenGeneration(): bool
    {
        return (bool) $this->scopeConfig->isSetFlag(self::XML_PATH_CONFIG_ENABLE_FOR_API_TOKEN_GENERATION);
    }
}
