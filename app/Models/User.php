<?php

namespace App\Models;

use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'avatar',
        'role',
    ];

    public function getInfoAttribute()
    {
        return $this->name . ' - ' . $this->phone;
    }
}
