<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackingKeyword extends Model
{
    //
    protected $table = 'config_tracking_keyword';
    protected $fillable = [
        'credentials', 'url', 'status','user_id'
    ];
}
