<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id')->comment = '供應商資料表主鍵';
            $table->string('code', 10)->unique()->comment = '供應商編號';
            $table->string('name', 50)->comment = '供應商名稱';
            $table->string('shortName', 10)->comment = '供應商簡稱';
            $table->string('boss', 10)->comment = '負責人';
            $table->string('contactPerson', 10)->comment = '聯絡人';
            $table->unsignedInteger('zip')->comment = '郵遞區號';
            $table->string('address')->comment = '地址';
            $table->string('email', 50)->comment = '電子郵件';
            $table->string('telphone', 20)->comment = '電話號碼';
            $table->string('cellphone', 20)->comment = '行動電話號碼';
            $table->string('fax', 20)->comment = '傳真號碼';
            $table->string('taxNumber', 10)->comment = '統一編號';
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
        Schema::drop('suppliers');
    }
}
