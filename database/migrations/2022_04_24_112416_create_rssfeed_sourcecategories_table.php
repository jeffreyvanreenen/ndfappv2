<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRssfeedSourcecategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('rssfeed_sourcecategories', function (Blueprint $table) {
            $table->foreignId('rssfeed_id');
            $table->foreignId('source_categorie_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rssfeed_sourcecategories');
    }
}
