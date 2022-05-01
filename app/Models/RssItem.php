<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class RssItem extends Model
{
    use Searchable;

    protected $casts = [
        'updated_at' => 'date:d-m-Y H:i:s',
        'created_at' => 'date:d-m-Y H:i:s',
        'pubDate' => 'date:d-m-Y H:i:s',
    ];

    protected $fillable = [
        'title',
        'link',
        'pubDate',
        'description',
        'source',
        'author',
        'flag',
        'created_at',
        'updated_at',
    ];

    protected $searchStringColumns = [
        'title', 'description', 'link', 'pubDate', 'source', 'author',
    ];

}
