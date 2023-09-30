<?php

namespace App\Models;

use App\Models\Time;
use App\Enums\StatusPitchEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pitch extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'pitch_area_id',
        'name',
        'type',
        'status',
    ];

    
}
