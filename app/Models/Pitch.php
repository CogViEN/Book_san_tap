<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function order() : HasMany
    {
        return $this->hasMany(Order::class);
    }
    
}
