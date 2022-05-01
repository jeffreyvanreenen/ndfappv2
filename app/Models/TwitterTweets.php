<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class TwitterTweets extends Model
{
    use Searchable;
    
    protected $fillable = [
        'tw_id',
        'author_id',
        'text',
        'tw_created_at',
        'tw_user_id',
        'tw_name',
        'tw_username',
        'media',
        'bron',
    ];
}
