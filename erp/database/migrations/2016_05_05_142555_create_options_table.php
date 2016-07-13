<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('class', 20)->comment('此記錄的類別');
            $table->string('code', 50)->comment('此類別的代碼');
            $table->string('comment', 20)->comment('此類別代碼的說明');
            $table->string('value', 20)->comment('此類別代碼的數值');
        });
    }

    /**
     * Reverse the migrations.
     *
     * 
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_options');
    }
}
