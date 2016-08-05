<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDiscountFieldInBillOfSaleMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('erp_bill_of_sale_detail', function (Blueprint $table) {
            $table->integer('discount')->nullable()->default(null)->change();
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
            $table->integer('discount')->default(100)->change();
        });
    }
}
