<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\UserRoleEnum;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return auth()->user()->role == UserRoleEnum::SUPER_ADMIN;
    }

    public function index2(User $user)
    {
        return auth()->user()->role == UserRoleEnum::SUPER_ADMIN ||
            auth()->user()->role == UserRoleEnum::ADMIN;
    }
}
