<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RSSfeed;

class SourceCatagory extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'updated_at' => 'date:d-m-Y H:i:s',
        'created_at' => 'date:d-m-Y H:i:s',
    ];

    protected $primaryKey = 'id';

    public function RSSfeeds()
    {
        return $this->belongsToMany('App\Models\RSSfeed', 'rssfeed_sourcecategories', 'source_categorie_id', 'rssfeed_id');
    }
}
