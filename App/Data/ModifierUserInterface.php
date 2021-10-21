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
    public const IS_ENABLE_TWOFACTORAUTH = 'is_enable_twofactorauth';
}
