<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldNameToPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('erp_pages', function (Blueprint $table) {
            $table->dropColumn('action');
            $table->string('route_name')->comment='menu對應到的route name';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('erp_pages', function (Blueprint $table) {
            $table->dropColumn('route_name');
            $table->string('action')->comment='menu對應到的action';
        });
    }
}
