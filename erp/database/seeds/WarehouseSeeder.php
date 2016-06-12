<?php

use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('warehouses')->insert([
            //倉庫資料
            [
                'code'    => 'KS',
                'name'    => '高雄倉',
                'comment' => '高雄倉',
            ],
            [
                'code'    => 'TP',
                'name'    => '台北倉',
                'comment' => '台北倉',
            ],
        ]);
    }
}
