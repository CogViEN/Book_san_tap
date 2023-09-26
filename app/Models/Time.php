<?php

namespace App\Models;

use App\Models\Pitch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Time extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'pitch_id',
        'timeslot',
        'cost',
        'created_at',
    ];

    public function pitch(): BelongsTo
    {
        return $this->belongsTo(Pitch::class);
    }
}
