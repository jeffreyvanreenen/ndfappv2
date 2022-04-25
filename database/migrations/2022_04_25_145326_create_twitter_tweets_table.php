<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwitterTweetsTable extends Migration
{
    public function up()
    {
        Schema::create('twitter_tweets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tw_id');
            $table->foreignId('author_id');
            $table->text('text');
            $table->dateTime('tw_created_at');
            $table->string('tw_user_id');
            $table->string('tw_name');
            $table->string('tw_username');
            $table->json('media')->nullable();
            $table->string('bron');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('twitter_tweets');
    }
}
