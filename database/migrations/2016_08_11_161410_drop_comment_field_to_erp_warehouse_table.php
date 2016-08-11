<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropCommentFieldToErpWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('erp_warehouses', function (Blueprint $table) {
            $table->dropColumn('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('erp_warehouses', function (Blueprint $table) {
            $table->string('comment', 20)->comment = '倉庫說明';
        });
    }
}
