<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StorageUrl extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('storageurl', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('url');
            $table->tinyInteger('status');
            $table->integer('user_id');
            $table->integer('config_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('storageurl');
    }
}
