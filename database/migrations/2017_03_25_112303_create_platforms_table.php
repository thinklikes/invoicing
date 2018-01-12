<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_platforms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment = "平台名稱";
            $table->string('isDisabled')->comment = "是否停用";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_platforms');
    }
}
