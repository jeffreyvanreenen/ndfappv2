<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelegramChatMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('telegram_chat_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('update_id');
            $table->string('message_id');
            $table->string('user_id');
            $table->string('user_first_name');
            $table->string('user_last_name');
            $table->string('user_username');
            $table->string('user_language_code');
            $table->string('chat_id');
            $table->dateTime('date');
            $table->text('text');
            $table->boolean('is_bot');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('telegram_chat_messages');
    }
}
