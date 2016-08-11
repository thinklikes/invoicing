<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayableWriteOffMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_payable_write_off_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 20)->unique()->comment = "付款單號";
            $table->integer('supplier_id')->comment = "供應商的id";
            $table->integer('debit_amount')->comment = "借方總金額";
            $table->integer('credit_amount')->comment = "貸方總金額";
            $table->string('note')->nullable()->comment = "備註";
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_payable_write_off_master');
    }
}
