<?php

use App\Enum\CheckStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checks', function (Blueprint $table) {
            $table->bigInteger('check_id')->unique()->primary();
            $table->string('image');
            $table->float('amount');
            $table->float('amount_in_currency');
            $table->dateTime('dt');
            $table->dateTime('dt_purchase');
            $table->string('currency');
            $table->integer('verify_quantity');
            $table->integer('current_quantity');
            $table->enum('status', CheckStatusEnum::statuses())->default(CheckStatusEnum::INCHECK);
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
        Schema::dropIfExists('checks');
    }
}
