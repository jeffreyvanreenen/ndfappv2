<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwitterMedia extends Model
{
    protected $fillable = [
        'media_key',
        'type',
        'url',
    ];
}
