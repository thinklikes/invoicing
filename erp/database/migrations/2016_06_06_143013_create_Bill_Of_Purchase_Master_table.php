<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillOfPurchaseMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_of_purchase_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 20)->unique()->comment = "進貨單號";
            $table->enum('is_paid', [0, 1])->default('0')->comment = "是否付款(0:未付款, 1:未付款)";
            $table->string('invoice_code', 10)->comment = "發票號碼";
            $table->integer('warehouse_id')->comment = "倉庫的id";
            $table->integer('supplier_id')->comment = "供應商的id";
            $table->string('tax_rate_code', 1)->comment = "稅別";
            $table->integer('total_amount')->comment = "總金額";
            $table->integer('paid_amount')->comment = "已付金額";
            $table->string('note', 255)->comment = "進貨單備註";
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
        Schema::drop('bill_of_purchase_master');
    }
}
