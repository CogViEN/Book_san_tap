<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserRoleEnum extends Enum
{
    const SUPER_ADMIN = 0;
    const ADMIN = 1;
    const OWNER = 2;
    const GUEST = 3;

    public static function getArrayView(): array
    {
        return [
            'Super Admin' => self::SUPER_ADMIN,
            'Admin' => self::ADMIN,
            'Owner' => self::OWNER,
            'Guest' => self::GUEST,
        ];
    }

    public static function getKeyByValue($value) : string
    {
        return array_search($value, self::getArrayView(), true);
    }
}
