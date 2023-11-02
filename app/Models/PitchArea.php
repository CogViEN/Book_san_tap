<?php

namespace App\Models;

use App\Models\Pitch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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

    public function pitch(): HasMany
    {
        return $this->hasMany(Pitch::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    

    public function scopeDetailOwner($query, $id)
    {
        return $query->with([
            'user' => function ($q) {
                return $q->select([
                    'id',
                    'name',
                    'phone',
                ]);
            },
        ])
            ->where('id', $id);
    }
}
