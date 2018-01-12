<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldCustomerOrderCodeToBillOfSaleMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('erp_bill_of_sale_master', function (Blueprint $table) {
            $table->string('customerOrderCode')->nullable()->after('code')->comment = '客戶訂單號碼';
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
            $table->dropColumn('customerOrderCode');
        });
    }
}
