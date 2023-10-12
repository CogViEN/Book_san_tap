<?php

namespace App\Models;

use App\Enums\UserRoleEnum;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model implements
AuthenticatableContract
{
    use HasFactory, Authenticatable;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'avatar',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

}
