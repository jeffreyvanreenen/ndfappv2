<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwitterFollowsTable extends Migration
{
    public function up()
    {
        Schema::create('twitter_follows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username');
            $table->string('name')->nullable();
            $table->string('tw_id')->nullable();
            $table->dateTime('tw_created_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('twitter_follows');
    }
}
