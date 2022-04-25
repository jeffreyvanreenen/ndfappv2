<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwitterMediaTable extends Migration
{
    public function up()
    {
        Schema::create('twitter_media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('media_key');
            $table->string('type');
            $table->string('url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('twitter_media');
    }
}
