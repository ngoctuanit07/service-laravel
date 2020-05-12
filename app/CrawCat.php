<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CrawCat extends Model
{
    //
    protected $table = 'crawcat';
    protected $fillable = [
        'title', 'content', 'featured_image', 'cat_url','user_id' ,
    ];
}
