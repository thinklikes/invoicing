<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNoteFieldInErpSaleOrderMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('erp_sale_order_master', function (Blueprint $table) {
            $table->string('note', 255)->nullable()->change();
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
            $table->string('note')->change();
        });
    }
}
