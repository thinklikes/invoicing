<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnOfSaleMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_return_of_sale_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 20)->unique()->comment = "銷貨退回單號";
            $table->enum('is_received', [0, 1])->comment = "是否收款(0:未付款, 1:已付款)";
            $table->string('invoice_code', 10)->comment = "發票號碼";
            $table->integer('warehouse_id')->comment = "倉庫的id";
            $table->integer('company_id')->comment = "客戶的id";
            $table->string('tax_rate_code', 1)->comment = "稅別";
            $table->integer('total_amount')->comment = "總金額";
            $table->integer('received_amount')->comment = "已收金額";
            $table->string('note', 255)->comment = "銷貨退回單備註";
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
        Schema::dropIfExists('erp_return_of_sale_master');
    }
}
