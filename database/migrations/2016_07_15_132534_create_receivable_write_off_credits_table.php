<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceivableWriteOffCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_receivable_write_off_credit', function (Blueprint $table) {
            $table->increments('id');
            $table->string('master_code', 20)->comment = "表頭單號";
            $table->enum('credit_type', ['billOfSale', 'returnOfSale'])->comment = "銷退貨單別";
            $table->string('credit_code', 20)->comment = "銷退貨單號";
            $table->integer('credit_amount')->comment = "銷退貨單沖銷金額";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_receivable_write_off_credit');
    }
}
