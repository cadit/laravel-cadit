<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('bank_code');
            $table->string('bank_name');
            $table->string('account_order_name');
            $table->integer('account_order_birthday');
            $table->smallInteger('account_type')->default(1)->comment('1: 개인, 2: 법인');
            $table->smallInteger('account_status')->default(1)->comment('1: 활성화, 2: 정지 (휴먼 포함)');
            $table->string('bank_account_number');
            $table->integer('bank_account_password');
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
        Schema::dropIfExists('finances');
    }
}
