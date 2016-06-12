<?php

use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suppliers')->truncate();
        //用模型工廠隨機填入五十筆供應商
        factory(App\Supplier::class, 50)->create();
    }
}
