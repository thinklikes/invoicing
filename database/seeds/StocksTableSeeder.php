<?php

use Illuminate\Database\Seeder;

class StocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('erp_stocks')->truncate();
        //用模型工廠隨機填入五十筆產品
        factory(Stock\Stock::class, 20)->create();
    }
}
