<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RebuildCompanySystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('company_system');
        Schema::create('company_system', function (Blueprint $table) {
            $table->increments('auto_id');
            $table->string('company_code', 10)->comment = '客戶編號';
            $table->string('company_name', 100)->comment = '公司名稱';
            $table->string('mailbox', 5)->nullable()->comment = '郵箱';
            $table->string('company_abb', 20)->comment = '公司簡稱';
            $table->string('company_contact', 100)->comment = '聯絡人';
            $table->string('company_con_tel', 100)->nullable()->comment = '聯絡人電話';
            $table->string('company_con_email', 100)->nullable()->comment = '聯絡人信箱';
            $table->string('boss', 10)->nullable();
            $table->string('company_tel', 100)->nullable()->comment = '公司電話';
            $table->string('company_fax', 100)->nullable()->comment = '公司傳真';
            $table->string('company_add', 100)->nullable()->comment = '公司地址';
            $table->string('VTA_NO', 11)->comment = '統一編號';
            $table->string('internet_phone', 12)->nullable()->comment = '網路電話號碼';
            $table->text('company_remark')->nullable()->comment = '公司備註';
            $table->string('company_status', 1)->default(1)->comment = '1:購買2:租用3:不使用';
            $table->string('line', 30)->nullable();
            $table->string('skype', 30)->nullable();
            $table->string('wechat', 30)->nullable();
            $table->string('contract', 10)->nullable();
            $table->char('show_msg', 1)->nullable()->comment = '是否提醒合約到期日';
            $table->string('remind', 200)->nullable()->comment = '提醒事項';
            $table->char('show_remind', 1)->nullable()->comment = '是否顯示提醒事項';

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('company_system');
    }
}
