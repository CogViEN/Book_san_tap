<?php

use App\Enums\UserRoleEnum;
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

if (!function_exists('getRoleByKey')) {
    function getRoleByKey($key): string
    {
        return strtolower(UserRoleEnum::getKeys((int)$key)[0]);
    }
}

if (!function_exists('user')) {
    function user(): ?object
    {
        return auth()->user();
    }
}

if (!function_exists('isSuperAdmin')) {
    function isSuperAdmin(): bool
    {
        return user() && user()->role === UserRoleEnum::SUPER_ADMIN;
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin(): bool
    {
        return user() && user()->role === UserRoleEnum::ADMIN;
    }
}