<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwitterListsTable extends Migration
{
    public function up()
    {
        Schema::create('twitter_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('list_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('twitter_lists');
    }
}
