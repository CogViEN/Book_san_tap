<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Time extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'pitch_area_id',
        'type',
        'timeslot',
        'cost',
        'created_at',
    ];

}
