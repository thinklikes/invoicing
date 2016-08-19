<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldsToUesrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('erp_users', function (Blueprint $table) {
            $table->string('email', 255)->nullable()->change()->comment = '電子郵件';
            $table->string('name', 255)->unique()->change()->comment = '使用者帳號';
            $table->string('employee_id', 20)->unique()->change()->comment = '使用者代號';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('erp_users', function (Blueprint $table) {
            $table->dropUnique('erp_users_name_unique');
            $table->dropUnique('erp_users_employee_id_unique');
            $table->string('email')->change();
            $table->string('name')->change();
            $table->integer('employee_id')->change();
        });
    }
}
