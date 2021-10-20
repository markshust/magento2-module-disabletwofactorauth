<?php

declare(strict_types=1);

namespace MarkShust\DisableTwoFactorAuth\App\Config;

/**
 * @api
 * Class TwoFactorAuthInterface
 * @package MarkShust\DisableTwoFactorAuth\App\Config
 */
interface TwoFactorAuthInterface
{

    public const XML_CONFIG_PATH_BASE = 'twofactorauth/';

    public const XML_CONFIG_PATH_GENERAL_SECTION = self::XML_CONFIG_PATH_BASE . 'general/';

    public const XML_CONFIG_PATH_ENABLE = self::XML_CONFIG_PATH_GENERAL_SECTION . 'enable';

    public const XML_PATH_CONFIG_ENABLE_FOR_API_TOKEN_GENERATION = self::XML_CONFIG_PATH_GENERAL_SECTION . 'enable_for_api_token_generation';

    /**
     * @return bool
     */
    public function isEnable(): bool;

    /**
     * @return bool
     */
    public function isEnableApiTokenGeneration(): bool;

}
