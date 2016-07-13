<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        //$this->call(CustomersTableSeeder::class);
        $this->call(SuppliersTableSeeder::class);
        $this->call(StocksTableSeeder::class);
        $this->call(OptionsTableSeeder::class);
        $this->call(WarehouseSeeder::class);
        $this->call(StockWarehouseSeeder::class);

        Model::reguard();
    }
}
