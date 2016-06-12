<?php

use Illuminate\Database\Seeder;

use App\Repositories\StockRepository;

use App\Repositories\WarehouseRepository;

class StockWarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stocks     = StockRepository::getAllStocksId();
        $warehouses = WarehouseRepository::getAllWarehousesId();
        $faker = new Faker\Generator;
        $faker->addProvider(new Faker\Provider\zh_TW\Person($faker));
        $faker->addProvider(new Faker\Provider\zh_TW\Address($faker));
        $faker->addProvider(new Faker\Provider\zh_TW\PhoneNumber($faker));
        $faker->addProvider(new Faker\Provider\zh_TW\Company($faker));
        $stocks_warehouses = array();
        $i = 0;
        foreach ($stocks as $stock) {
            foreach ($warehouses as $warehouse) {
                $stocks_warehouses[$i]['stock_id']     = $stock->id;
                $stocks_warehouses[$i]['warehouse_id'] = $warehouse;
                $stocks_warehouses[$i]['inventory']    = 0.00;
                $i ++;
            }
        }
        DB::table('stocks_warehouses')->insert($stocks_warehouses);
    }
}
