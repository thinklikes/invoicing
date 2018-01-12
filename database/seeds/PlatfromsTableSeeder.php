<?php

use Illuminate\Database\Seeder;

class PlatformsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('erp_platforms')->truncate();
        DB::table('erp_platforms')->insert([
            ['name' => 'QDM', 'isDisabled' => 0],
            ['name' => 'QDM2', 'isDisabled' => 0],
            ['name' => '91APP', 'isDisabled' => 0],
            ['name' => 'yahoo', 'isDisabled' => 0],
            ['name' => 'YAHOO超商', 'isDisabled' => 0],
            ['name' => '生活市集', 'isDisabled' => 0],
            ['name' => '姐妹購物網', 'isDisabled' => 0],
            ['name' => '好吃宅配網', 'isDisabled' => 0],
            ['name' => '夠麻吉', 'isDisabled' => 0],
            ['name' => '森森', 'isDisabled' => 0],
            ['name' => '東森', 'isDisabled' => 0],
            ['name' => '樂天', 'isDisabled' => 0],
        ]);
    }
}
