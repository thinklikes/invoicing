<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_warehouses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 20)->comment = '倉庫代碼';
            $table->string('name', 20)->comment = '倉庫名稱';
            $table->string('comment', 20)->comment = '倉庫說明';
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
        Schema::dropIfExists('erp_warehouses');
    }
}
