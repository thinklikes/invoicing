<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FieldsModifinedToErpPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('erp_pages', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropUnique('erp_pages_code_unique');
            $table->primary('code');
        });
        Schema::table('erp_auths', function (Blueprint $table) {
            $table->dropColumn('id');
            //$table->dropUnique('erp_pages_code_unique');
            $table->primary('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('ALTER TABLE `erp_pages` DROP PRIMARY KEY');
        Schema::table('erp_pages', function (Blueprint $table) {

            $table->increments('id')->first();
            $table->unique('code');
        });

        DB::unprepared('ALTER TABLE `erp_auths` DROP PRIMARY KEY');
        Schema::table('erp_auths', function (Blueprint $table) {

            $table->increments('id')->first();
        });
    }
}
