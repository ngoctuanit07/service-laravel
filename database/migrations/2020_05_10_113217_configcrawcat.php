<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Configcrawcat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('configcrawcat', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->longText('cat_url');
            $table->longText('title');
            $table->longText('content');
            $table->longText('imageUrl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('configcrawcat');
    }
}
