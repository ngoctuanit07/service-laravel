<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Craw extends Model {
    //
    protected $table = 'craw';
    protected $fillable = [
        'title', 'content', 'featured_image', 'cat_id' ,
    ];
}
