<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToErpUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('erp_users', function (Blueprint $table) {
            $table->string('emp_name', 30)->comment = '員工姓名';
            $table->string('out_at', 9)->comment = '離值日';
            $table->tinyInteger('leavl')->default(0)->comment = '0:一般1:管理者';
            $table->tinyInteger('status')->default(1)->comment = '0:離職1:在職';
            $table->string('remark', 200)->comment = '備註';
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
            $table->dropColumn(['emp_name', 'out_at', 'leavl', 'status', 'remark']);
        });
    }
}
