<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRssItemsTable extends Migration
{
    public function up()
    {
        Schema::create('rss_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->text('link')->nullable();
            $table->dateTime('pubDate')->nullable();
            $table->longText('description')->nullable();
            $table->string('source')->nullable();
            $table->string('author')->nullable();
            $table->boolean('flag')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rss_items');
    }
}
