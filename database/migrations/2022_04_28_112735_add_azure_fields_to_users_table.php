<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('azure_nickname')->nullable();
            $table->string('azure_avatar')->nullable();
            $table->json('azure_userinfo')->nullable();
            $table->string('azure_job_title')->nullable();
            $table->string('azure_givenName')->nullable();
            $table->string('azure_surname')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
