<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 20)->unique()->comment = "採購單號";
            $table->date('delivery_date')->comment = "交貨日期";
            $table->string('supplier_code', 10)->comment = "供應商的code";
            $table->string('tax_rate_code', 1)->comment = "稅別";
            $table->string('note', 255)->comment = "採購單備註";
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
        Schema::drop('purchase_order_master');
    }
}
