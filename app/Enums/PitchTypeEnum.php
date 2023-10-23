<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PitchTypeEnum extends Enum
{
    const SAN5 = 5;
    const SAN7 = 7;
    const SAN11 = 11;
    const SAN_FUTSAL = 6;

    public static function getArrayView(): array
    {
        return [
            'Sân 5 người' => self::SAN5,
            'Sân 7 người' => self::SAN7,
            'Sân 11 người' => self::SAN11,
            'Sân fustal' => self::SAN_FUTSAL,
        ];
    }

    public static function getKeyByValue($value): string
    {
        return array_search($value, self::getArrayView(), true);
    }
}
