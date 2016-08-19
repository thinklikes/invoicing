<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_auths', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('level')->unique()->comment = '使用者權限的等級';
            $table->string('code', 20)->comment = '使用者權限的代碼';
            $table->string('comment', 20)->comment = '使用者權限的說明';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_auths');
    }
}
