<?php

namespace App\Models;

use App\Models\Pitch;
use App\Models\PitchArea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'phone',
        'price',
        'status',
        'require',
        'pitch_id',
        'timeslot',
        'created_at',
    ];

    public function pitch() : BelongsTo
    {
        return $this->belongsTo(Pitch::class);
    }

}
