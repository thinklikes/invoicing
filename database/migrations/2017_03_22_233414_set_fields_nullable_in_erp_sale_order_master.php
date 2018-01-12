<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetFieldsNullableInErpSaleOrderMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('erp_sale_order_master', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->change();
            $table->string('customer_tel')->nullable()->change();
            $table->string('customer_email')->nullable()->change();
            $table->string('recipient')->nullable()->change();
            $table->string('recipient_tel')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('zip')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('payway')->nullable()->change();
            $table->datetime('transfer_time')->nullable()->change();
            $table->string('transfer_code')->nullable()->change();
            $table->string('bank')->nullable()->change();
            $table->string('delivery_method')->nullable()->change();
            $table->date('delivery_date')->nullable()->change();
            $table->string('delivery_time')->nullable()->change();
            $table->text('words_to_boss')->nullable()->change();
            $table->string('taxNumber')->nullable()->change();
            $table->string('InvoiceName')->nullable()->change();
            $table->string('order_status', 10)->nullable()->change();
            $table->string('pay_status', 10)->nullable()->change();
            $table->string('note', 10)->nullable()->change();
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
            $table->string('customer_name')->change();
            $table->string('customer_tel')->change();
            $table->string('customer_email')->change();
            $table->string('recipient')->change();
            $table->string('recipient_tel')->change();
            $table->string('city')->change();
            $table->string('zip')->nullable()->change();
            $table->string('address')->change();
            $table->string('payway')->change();
            $table->datetime('transfer_time')->change();
            $table->string('transfer_code')->nullable()->change();
            $table->string('bank')->nullable()->change();
            $table->string('delivery_method')->change();
            $table->date('delivery_date')->change();
            $table->string('delivery_time')->change();
            $table->text('words_to_boss')->nullable()->change();
            $table->string('taxNumber')->nullable()->change();
            $table->string('InvoiceName')->nullable()->change();
            $table->string('order_status', 10)->change();
            $table->string('pay_status', 10)->change();
        });
    }
}
