<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigCrawCat extends Model
{
    //
    protected $table = 'configcrawcat';
    protected $fillable = [
        'title', 'content', 'featured_image','contentfull', 'cat_url','user_id' ,
    ];
}
