<?php

use App\Models\Time;
use App\Models\Pitch;
use App\Models\PitchArea;
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

if (!function_exists('isOwner')) {
    function isOwner(): bool
    {
        return user() && user()->role === UserRoleEnum::OWNER;
    }
}

if (!function_exists('checkPitchAreaBelongThisUser')) {
    function checkPitchAreaBelongThisUser($user_id, $pitch_area_id): bool
    {
        $checkExists = PitchArea::query()
            ->where('id', $pitch_area_id)
            ->where('user_id', $user_id)
            ->exists();

        return $checkExists;
    }
}

if (!function_exists('getNamePitchArea')) {
    function getNamePitchArea($pitch_area_id): string
    {
        $res = PitchArea::where('id', $pitch_area_id)
            ->value('name');
        return $res ?? '';
    }
}

if (!function_exists('getCacheTimeSlots')) {
    function getCacheTimeSlots()
    {
        return cache()->remember('cacheTimeslots', 24 * 60 * 60, function () {
            $timeslots = Time::select('timeslot')
                ->where('pitch_area_id', 1)
                ->where('type', 5)
                ->pluck('timeslot');

            return $timeslots;
        });
    }
}

if (!function_exists('getTypesThisPitch')) {
    function getTypesThisPitch($pitchareaId)
    {
        $types = Pitch::select('type')
            ->where('pitch_area_id', $pitchareaId)
            ->where('status', StatusPitchEnum::ACTIVE)
            ->distinct()
            ->get();

        $res = [];

        foreach ($types as $each) {
            $res[$each->type] = PitchTypeEnum::getKeyByValue($each->type);
        }

        return $res;
    }
}

if (!function_exists('getNumberTimeSlot')) {
    function getNumberTimeSlot($now)
    {
        return 19 - ($now + 1) + 5;
    }
}
