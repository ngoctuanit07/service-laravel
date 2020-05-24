<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StorageUrl extends Model
{
    protected $table = 'storageurl';
    protected $primarykey = 'id';
    protected $fillable = [
         'url', 'status', 'user_id','config_id'
    ];
}
