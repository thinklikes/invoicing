<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_stock_warehouse', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stock_id')->comment = '料品id';
            $table->integer('warehouse_id')->comment = '倉庫id';
            $table->decimal('inventory', 10, 2)->default(0)->comment = '存量';
            $table->decimal('opening_inventory', 10, 2)->default(0)->comment = '期初存量';
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
        Schema::dropIfExists('erp_stock_warehouse');
    }
}
