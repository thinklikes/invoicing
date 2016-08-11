<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillOfSaleMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_bill_of_sale_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 20)->unique()->comment = "銷貨單號";
            $table->enum('is_received', [0, 1])->default('0')->comment = "是否收款(0:未收款, 1:已收款)";
            $table->string('invoice_code', 10)->comment = "發票號碼";
            $table->integer('warehouse_id')->comment = "倉庫的id";
            $table->integer('company_id')->comment = "客戶的id";
            $table->string('tax_rate_code', 1)->comment = "稅別";
            $table->integer('total_amount')->comment = "總金額";
            $table->integer('received_amount')->comment = "已收金額";
            $table->string('note', 255)->comment = "備註";
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_bill_of_sale_master');
    }
}
