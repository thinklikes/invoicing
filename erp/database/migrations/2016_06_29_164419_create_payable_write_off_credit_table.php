<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayableWriteOffCreditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payable_write_off_credit', function (Blueprint $table) {
            $table->increments('id');
            $table->string('master_code', 20)->comment = "表頭單號";
            $table->string('credit_code', 20)->comment = "付款單號";
            $table->integer('credit_amount')->comment = "付款單沖銷金額";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payable_write_off_credit');
    }
}
