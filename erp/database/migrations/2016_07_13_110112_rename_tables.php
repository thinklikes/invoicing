<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::rename('users', 'erp_users');
        } catch (Exception $e) {}
        // Schema::rename('pages', 'erp_pages');
        // Schema::rename('employees', 'erp_employees');
        // Schema::rename('stocks', 'erp_stocks');
        // Schema::rename('options', 'erp_options');
        // Schema::rename('stock_warehouses', 'erp_stock_warehouse');
        // Schema::rename('warehouses', 'erp_warehouses');
        // Schema::rename('purchase_order_master', 'erp_purchase_order_master');
        // Schema::rename('purchase_order_detail', 'erp_purchase_order_detail');
        // Schema::rename('bill_of_purchase_master', 'erp_bill_of_purchase_master');
        // Schema::rename('bill_of_purchase_detail', 'erp_bill_of_purchase_detail');
        // Schema::rename('return_of_purchase_master', 'erp_return_of_purchase_master');
        // Schema::rename('return_of_purchase_detail', 'erp_return_of_purchase_detail');
        // Schema::rename('payment', 'erp_payment');
        // Schema::rename('payable_write_off_master', 'erp_payable_write_off_master');
        // Schema::rename('payable_write_off_debit', 'erp_payable_write_off_debit');
        // Schema::rename('payable_write_off_credit', 'erp_payable_write_off_credit');
        // Schema::drop('customers');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {
            Schema::rename('erp_users', 'users');
        } catch (Exception $e) {}
        //Schema::dropIfExists('erp_users');
        // Schema::dropIfExists('erp_suppliers');
        // Schema::dropIfExists('erp_pages');
        // Schema::dropIfExists('erp_employees');
        // Schema::dropIfExists('erp_stocks');
        // Schema::dropIfExists('erp_options');
        // Schema::dropIfExists('erp_stock_warehouse');
        // Schema::dropIfExists('erp_warehouses');
        // Schema::dropIfExists('erp_purchase_order_master');
        // Schema::dropIfExists('erp_purchase_order_detail');
        // Schema::dropIfExists('erp_bill_of_purchase_master');
        // Schema::dropIfExists('erp_bill_of_purchase_detail');
        // Schema::dropIfExists('erp_return_of_purchase_master');
        // Schema::dropIfExists('erp_return_of_purchase_detail');
        // Schema::dropIfExists('erp_payment');
        // Schema::dropIfExists('erp_payable_write_off_master');
        // Schema::dropIfExists('erp_payable_write_off_debit');
        // Schema::dropIfExists('erp_payable_write_off_credit');
    }
}
