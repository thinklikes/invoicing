<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleOrderMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_sale_order_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 20)->unique()->comment = "客戶訂單號";
            $table->string('platform', 10)->comment = "平台名稱";
            $table->string('platform_code', 50)->comment = "電商平台訂單號";
            $table->datetime('upload_time')->comment = "excel上傳時間";
            $table->datetime('date_of_buying')->comment = "購買日期";
            $table->string('customer_name')->comment = "購買人";
            $table->string('customer_tel')->comment = "購買人電話";
            $table->string('customer_email')->comment = "電子郵件";
            $table->string('recipient')->comment = "收件人";
            $table->string('recipient_tel')->comment = "收件人電話";
            $table->string('city')->comment = "縣市";
            $table->string('zip')->nullable()->comment = "郵遞區號";
            $table->string('address')->comment = "收件地址";
            $table->string('payway')->comment = "付款方式";
            $table->datetime('transfer_time')->comment = "匯款時間";
            $table->string('transfer_code')->nullable()->comment = "匯款後5碼";
            $table->string('bank')->nullable()->comment = "匯款銀行";
            $table->string('delivery_method')->comment = "配送方式";
            $table->date('delivery_date')->comment = "希望送達日期";
            $table->string('delivery_time')->comment = "希望送達時段";
            $table->text('words_to_boss')->nullable()->comment = "給店長的話";
            $table->string('taxNumber')->nullable()->comment = "統一編號";
            $table->string('InvoiceName')->nullable()->comment = "發票抬頭";
            $table->string('note')->comment = "訂單備註";
            $table->string('order_status', 10)->comment = "訂單狀態";
            $table->string('pay_status', 10)->comment = "付款狀態";
            $table->string('tag')->comment = "過濾後的標籤";
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
        Schema::dropIfExists('erp_sale_order_master');
    }
}
