<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unique()->nullable();
            $table->string('user_fio');
            $table->string('user_email');
            $table->string('user_phone')->nullable();
            $table->bigInteger('referer_user_id')->nullable();
            $table->string('referer_user_fio')->nullable();
            $table->bigInteger('career_id')->nullable();
            $table->string('token_id')->nullable();
            $table->bigInteger('balance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
