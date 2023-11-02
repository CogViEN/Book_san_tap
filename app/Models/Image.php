<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'object-id',
        'path',
        'type',
    ];

    public function scopeGetImages($query,$id)
    {
        return $query->where('object-id', $id)
                        ->where('type', 1);
    }
}
