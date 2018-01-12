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
        //DB::table('erp_stocks')->truncate();
        //用模型工廠隨機填入五十筆產品
        //factory(Stock\Stock::class, 20)->create();
        DB::table('erp_stocks')->insert([
            [
                'code'   => 'FEE',
                'name'    => '運費',
                'stock_class_id' => '3',
                'unit_id'   => '3',
                'no_tax_price_of_purchased' => 0,
                'no_tax_price_of_sold' => 0,
            ],
            [
                'code'   => 'DISCOUNT',
                'name'    => '活動折扣',
                'stock_class_id' => '3',
                'unit_id'   => '3',
                'no_tax_price_of_purchased' => 0,
                'no_tax_price_of_sold' => 0,
            ],
        ]);
    }
}
