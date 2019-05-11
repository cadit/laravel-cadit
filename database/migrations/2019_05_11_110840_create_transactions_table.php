<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('deposit_id')->default(NULL);
            $table->smallInteger('inout_type')->comment('입출금구분 1: 입금, 2: 출금');
            $table->smallInteger('transaction_type')->default(1)->comment('거래구분');
            $table->string('memo');
            $table->integer('amount');
            $table->string('branch_name')->default('거래점명');
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
        Schema::dropIfExists('transactions');
    }
}
