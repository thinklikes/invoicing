<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsCollFieldToErpSaleOrderMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('erp_sale_order_master', function (Blueprint $table) {
            $table->string('isCool', 1)->default(0)->comment = '是否冷藏';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('erp_sale_order_master', function (Blueprint $table) {
            $table->dropColumn('isCool');
        });
    }
}
