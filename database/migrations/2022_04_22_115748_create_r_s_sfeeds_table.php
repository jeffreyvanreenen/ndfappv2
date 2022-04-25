<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRSSfeedsTable extends Migration
{
    public function up()
    {
        Schema::create('r_s_sfeeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('language')->nullable();
            $table->string('copyright')->nullable();
            $table->dateTime('pubDate')->nullable();
            $table->dateTime('lastBuildDate')->nullable();
            $table->string('image_url')->nullable();
            $table->text('url')->nullable();
            $table->boolean('error')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('r_s_sfeeds');
    }
}
