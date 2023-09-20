<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    public function getInformationAttribute()
    {
        return '#' . $this->id . ' - ' . $this->name;
    }
}
