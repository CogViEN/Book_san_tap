<?php

namespace App\Models;

use App\Models\Pitch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PitchArea extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'province', 
        'district',
        'description',
    ];

    public function pitch() : HasMany
    {
        return $this->hasMany(Pitch::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
