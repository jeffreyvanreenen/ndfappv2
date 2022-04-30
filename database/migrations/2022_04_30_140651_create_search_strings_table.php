<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchStringsTable extends Migration
{
    public function up()
    {
        Schema::create('search_strings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('color');
            $table->text('searchstring');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('search_strings');
    }
}
