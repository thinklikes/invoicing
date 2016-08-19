<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldsSequenceToUesrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('erp_users', function (Blueprint $table) {
            $table->string('employee_id', 20)->after('id')->change()->comment = '使用者代號';
            $table->string('emp_name', 30)->after('employee_id')->change()->comment = '使用者姓名';
            $table->string('phone', 12)->after('emp_name')->defaule('')->change()->comment = '電話';
            $table->string('email')->after('phone')->nullable()->default(null)->change()->comment = '電子郵件';
            $table->timestamp('created_at')->after('email')->change();
            $table->string('out_at', 20)->after('created_at')->change()->comment = '離職日';
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
            //
        });
    }
}
