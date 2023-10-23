<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PitchTime extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'pitch_id',
        'timeslot',
        'will_do',
    ];
}
