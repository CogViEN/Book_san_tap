<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;


final class StatusPitchEnum extends Enum
{
    const MAINTENANCE = 0;
    const ACTIVE = 1;

    public static function getArrayView(): array
    {
        return [
            'is maintenance' => self::MAINTENANCE,
            'is active' => self::ACTIVE,
        ];
    }

    public static function getKeyByValue($value): string
    {
        return array_search($value, self::getArrayView(), true);
    }
}
