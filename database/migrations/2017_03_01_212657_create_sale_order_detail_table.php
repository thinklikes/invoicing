<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_sale_order_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->string('master_code', 20)->comment = "客戶訂單號";
            $table->string('item')->comment = "訂購商品";
            $table->integer('price')->comment = "單價";
            $table->integer('quantity')->comment = "商品數量";
            $table->string('note')->comment = "備註";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_sale_order_detail');
    }
}
