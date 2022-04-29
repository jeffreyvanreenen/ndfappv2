<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SourceCatagory;

class RSSfeed extends Model
{
    protected $casts = [
        'updated_at' => 'date:d-m-Y H:i:s',
        'created_at' => 'date:d-m-Y H:i:s',
        'pubDate' => 'date:d-m-Y H:i:s',
        'lastBuildDate' => 'date:d-m-Y H:i:s',
    ];

    protected $primaryKey = 'id';

    public function SourceCategories()
    {
        return $this->belongsToMany(SourceCatagory::class, 'rssfeed_sourcecategories', 'rssfeed_id', 'source_categorie_id');
    }

}
