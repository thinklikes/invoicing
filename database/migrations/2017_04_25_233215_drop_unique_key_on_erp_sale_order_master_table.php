<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropUniqueKeyOnErpSaleOrderMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('erp_sale_order_master', function (Blueprint $table) {
            $table->dropUnique('erp_sale_order_master_code_unique');
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
            $table->string('code', 20)->unique()->change();
        });
    }
}
