<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Crawcat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('crawcat', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->longText('cat_url');
            $table->longText('title');
            $table->longText('content');
            $table->longText('featured_image')->nullable();
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
        Schema::dropIfExists('crawcat');
    }
}
