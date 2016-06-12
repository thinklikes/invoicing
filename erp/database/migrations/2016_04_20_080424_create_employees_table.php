<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment = '員工資料表主鍵';
            $table->string('code', 10)->comment = '員工編號';
            $table->string('name', 20)->comment = '姓名';
            $table->enum('gender', ['男', '女'])->comment = '性別';
            $table->string('email', 50)->comment = '電子郵件';
            $table->string('telphone', 20)->comment = '電話號碼';
            $table->string('cellphone', 20)->comment = '行動電話號碼';
            $table->tinyinteger('county_id')->comment = '縣市別的id';
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
        Schema::drop('employees');
    }
}
