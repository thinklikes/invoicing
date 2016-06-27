<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentOfPurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_of_purchase', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 20)->unique()->comment = "付款單號";
            $table->date('pay_date')->comment = "付款日期";
            $table->integer('supplier_id')->comment = "供應商的id";
            $table->enum('type', ['cash', 'check'])->comment = "付款方式類別";
            $table->integer('amount')->unsigned()->comment = "付款金額";
            $table->string('check_code', 20)->nullable()->comment = "票據號碼";
            $table->date('expiry_date')->nullable()->comment = "票據到期日";
            $table->string('bank_account', 50)->nullable()->comment = "銀行帳號";
            $table->string('note')->nullable()->comment = "備註";
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
        Schema::drop('payment_of_purchase');
    }
}
