<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiscountFieldToBillOfSaleDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('erp_bill_of_sale_detail', function (Blueprint $table) {
            $table->float('discount')->default(1)->after('quantity')->comment='銷貨折扣';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('erp_bill_of_sale_detail', function (Blueprint $table) {
            $table->dropColumn('discount');
        });
    }
}
