<?php

use Illuminate\Database\Seeder;

use Stock\StockRepository;

use Warehouse\WarehouseRepository;

class StockWarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('erp_stock_warehouse')->truncate();
        $stocks     = App::make(StockRepository::class);
        $warehouses = WarehouseRepository::getAllWarehousesId();
        $faker = new Faker\Generator;
        $faker->addProvider(new Faker\Provider\zh_TW\Person($faker));
        $faker->addProvider(new Faker\Provider\zh_TW\Address($faker));
        $faker->addProvider(new Faker\Provider\zh_TW\PhoneNumber($faker));
        $faker->addProvider(new Faker\Provider\zh_TW\Company($faker));
        $stocks_warehouses = array();
        $i = 0;
        foreach ($stocks->getAllStockNameAndCode() as $stock) {
            $stock->warehouse()->attach(WarehouseRepository::getAllWarehousesId());
        }
    }
}
