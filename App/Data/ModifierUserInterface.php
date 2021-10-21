<?php

declare(strict_types=1);

namespace MarkShust\DisableTwoFactorAuth\App\Data;

use Magento\User\Api\Data\UserInterface;

/**
 * Class ModifierUserInterface
 * @package MarkShust\DisableTwoFactorAuth\App\Data
 */
interface ModifierUserInterface extends UserInterface
{
    public const IS_ENABLE_2FA_AUTH = 'is_enable_2fa';
    public const FIELD_2FA_DISABLE = false;
    public const FIELD_2FA_ENABLE = true;
}
