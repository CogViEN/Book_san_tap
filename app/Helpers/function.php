<?php

use App\Enums\PitchTypeEnum;
use App\Enums\StatusPitchEnum;

if (!function_exists('getCacheStatusPitch')) {
    function getCacheStatusPitch()
    {
        return cache()->remember('statusPitch', 24 * 60 * 60, function () {
            return StatusPitchEnum::getArrayView();
        });
    }
}

if (!function_exists('getCacheTypePitch')) {
    function getCacheTypePitch()
    {
        return cache()->remember('typePitch', 24 * 60 * 60, function () {
            return PitchTypeEnum::getArrayView();
        });
    }
}

