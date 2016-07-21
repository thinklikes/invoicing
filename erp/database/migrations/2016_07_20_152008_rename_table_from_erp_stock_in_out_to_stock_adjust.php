<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTableFromErpStockInOutToStockAdjust extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('erp_stock_in_out_master', 'erp_stock_adjust_master');
        Schema::rename('erp_stock_in_out_detail', 'erp_stock_adjust_detail');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('erp_stock_adjust');
    }
}
