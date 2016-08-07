<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldPhoneToErpUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('erp_users', function (Blueprint $table) {
            $table->string('phone', 12)->after('emp_name')->comment = '電話';
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
            $table->dropColumn('phone')->comment;
        });
    }
}
