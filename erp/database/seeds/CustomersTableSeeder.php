<?php

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_system')->truncate();
        //用模型工廠隨機填入五十筆客戶
        factory(Company\Company::class, 50)->create();
    }
}
