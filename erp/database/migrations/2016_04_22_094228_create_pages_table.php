<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique()->comment='menu的代號';
            $table->string('name', 20)->comment='menu的名稱';
            $table->tinyInteger('level')->comment='menu的等級';
            $table->string('action')->comment='menu對應到的action';
            $table->enum('enabled', [1, 0])->default(1)->comment='這個頁面是否使用';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pages');
    }
}
