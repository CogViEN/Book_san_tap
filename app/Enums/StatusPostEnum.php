<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;


final class StatusPostEnum extends Enum
{
    const PENDING = 0;
    const ACCEPT = 1;
    const ABORT = -1;

    public static function getArrayView(): array
    {
        return [
            'Pending' => self::PENDING,
            'Accept' => self::ACCEPT,
            'Abort' => self::ABORT,
        ];
    }

    public static function getKeyByValue($value): string
    {
        return array_search($value, self::getArrayView(), true);
    }
}
