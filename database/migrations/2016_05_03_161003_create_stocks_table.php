<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_stocks', function (Blueprint $table) {
            $table->increments('id')->comment = '料品資料表主鍵';
            $table->string('code', 10)->comment = '料品代號';
            $table->string('name', 50)->comment = '料品名稱';
            $table->string('stock_class_id', 10)->comment = '料品類別的id';
            $table->string('unit_id', 10)->comment = '料品單位的id';
            $table->decimal('net_weight', 5, 2)->comment = '淨重';
            $table->decimal('gross_weight', 5, 2)->comment = '毛重';
            $table->string('note')->comment = '備註';
            $table->decimal('no_tax_price_of_purchased', 10, 2)->comment = '進貨價格';
            $table->decimal('no_tax_price_of_sold', 10, 2)->comment = '銷貨價格';
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
        Schema::dropIfExists('erp_stocks');
    }
}
