<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_page_auths', function (Blueprint $table) {
            $table->increments('id');
            $table->string('page_code', 10);
            $table->tinyInteger('auth_level');
        });

        DB::statement("ALTER TABLE `erp_page_auths` comment '權限設定表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_page_auths');
    }
}
