<?php

use App\Enum\CheckHistoryStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->bigInteger('check_id');
            $table->foreign('check_id')->references('check_id')->on('checks')->cascadeOnDelete();
            $table->enum('status', CheckHistoryStatusEnum::statuses())->nullable();
            $table->float('reward')->nullable();
            $table->text('comment')->nullable();
            $table->unique(['user_id', 'check_id']);
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
        Schema::dropIfExists('check_histories');
    }
}
