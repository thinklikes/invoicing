<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockInOutMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_stock_in_out_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 20)->unique()->comment = "調整單號";
            //$table->enum('is_paid', [0, 1])->default('0')->comment = "是否付款(0:未付款, 1:已付款)";
            $table->integer('warehouse_id')->comment = "倉庫的id";
            $table->integer('total_amount')->comment = "總金額";
            //$table->integer('paid_amount')->comment = "已付金額";
            $table->string('note', 255)->comment = "調整單備註";
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
        Schema::dropIfExists('erp_stock_in_out_master');
    }
}
