<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_stock_out_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_type', 20)->comment = '異動單據的類型';
            $table->string('order_code', 20)->comment = '異動單據的單號';
            $table->integer('warehouse_id')->comment = '倉庫的id';
            $table->integer('stock_id')->comment = '料品的id';
            $table->decimal('quantity')->comment = "異動數量";
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
        Schema::dropIfExists('erp_stock_out_logs');
    }
}
