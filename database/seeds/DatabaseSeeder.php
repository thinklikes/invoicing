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
        $this->call(OptionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        // $this->call(CustomersTableSeeder::class);
        // $this->call(SuppliersTableSeeder::class);
        $this->call(StocksTableSeeder::class);
        // $this->call(WarehouseSeeder::class);
        // $this->call(StockWarehouseSeeder::class);
        $this->call(AuthsTableSeeder::class);
        $this->call(PageAuthsTableSeeder::class);

        Model::reguard();
    }
}
