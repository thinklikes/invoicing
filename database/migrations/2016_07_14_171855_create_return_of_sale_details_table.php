<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnOfSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_return_of_sale_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->string('master_code', 20)->comment = "進貨退回單的code";
            $table->integer('stock_id')->comment = "料品的id";
            $table->decimal('quantity')->comment = "進貨數量";
            $table->decimal('no_tax_price')->comment = "單一個料品的未稅價格";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_return_of_sale_detail');
    }
}
