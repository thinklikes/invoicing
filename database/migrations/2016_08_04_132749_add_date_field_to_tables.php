<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateFieldToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('erp_bill_of_sale_master', function (Blueprint $table) {
            $table->date('date')->default('0000-00-00')
                ->after('id')->comment = '開單日期';
        });
        Schema::table('erp_return_of_sale_master', function (Blueprint $table) {
            $table->date('date')->default('0000-00-00')
                ->after('id')->comment = '開單日期';
        });
        Schema::table('erp_bill_of_purchase_master', function (Blueprint $table) {
            $table->date('date')->default('0000-00-00')
                ->after('id')->comment = '開單日期';
        });
        Schema::table('erp_return_of_purchase_master', function (Blueprint $table) {
            $table->date('date')->default('0000-00-00')
                ->after('id')->comment = '開單日期';
        });
        Schema::table('erp_stock_adjust_master', function (Blueprint $table) {
            $table->date('date')->default('0000-00-00')
                ->after('id')->comment = '開單日期';
        });
        Schema::table('erp_stock_transfer_master', function (Blueprint $table) {
            $table->date('date')->default('0000-00-00')
                ->after('id')->comment = '開單日期';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('erp_bill_of_sale_master', function (Blueprint $table) {
            $table->dropColumn('date');
        });
        Schema::table('erp_return_of_sale_master', function (Blueprint $table) {
            $table->dropColumn('date');
        });
        Schema::table('erp_bill_of_purchase_master', function (Blueprint $table) {
            $table->dropColumn('date');
        });
        Schema::table('erp_return_of_purchase_master', function (Blueprint $table) {
            $table->dropColumn('date');
        });
        Schema::table('erp_stock_adjust_master', function (Blueprint $table) {
            $table->dropColumn('date');
        });
        Schema::table('erp_stock_transfer_master', function (Blueprint $table) {
            $table->dropColumn('date');
        });
    }
}
