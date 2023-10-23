<?php

namespace App\Models;

use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'heading',
        'description',
        'avatar',
        'status',
        'created_at',
    ];

    public function getDescriptionAttribute()
    {
        return new HtmlString($this->attributes['description']);
    }

}
