<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayableWriteOffDebitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_payable_write_off_debit', function (Blueprint $table) {
            $table->increments('id');
            $table->string('master_code', 20)->comment = "表頭單號";
            $table->enum('debit_type', ['billOfPurchase', 'returnOfPurchase'])->comment = "進退貨單別";
            $table->string('debit_code', 20)->comment = "進退貨單號";
            $table->integer('debit_amount')->comment = "進退貨單沖銷金額";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_payable_write_off_debit');
    }
}
