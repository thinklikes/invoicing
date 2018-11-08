<?php

use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //先清空
        DB::table('erp_options')->truncate();

        DB::table('erp_options')->insert([
            //料品單位
            [
                'class'   => 'units',
                'code'    => 'KG',
                'comment' => '公斤',
                'value'   => '',
            ],
            [
                'class'   => 'units',
                'code'    => 'G',
                'comment' => '公克',
                'value'   => '',
            ],
            [
                'class'   => 'units',
                'code'    => 'SET',
                'comment' => '組',
                'value'   => '',
            ],

            //料品類別
            [
                'class'   => 'stock_classes',
                'code'    => 'A',
                'comment' => '軟體類',
                'value'   => '',
            ],
            [
                'class'   => 'stock_classes',
                'code'    => 'B',
                'comment' => '硬體類',
                'value'   => '',
            ],
            [
                'class'   => 'stock_classes',
                'code'    => 'C',
                'comment' => '服務類',
                'value'   => '',
            ],

            //付款方式
            // [
            //     'class'   => 'pay_ways',
            //     'code'    => 'A01',
            //     'comment' => '月結30天',
            //     'value'   => '',
            // ],
            // [
            //     'class'   => 'pay_ways',
            //     'code'    => 'A02',
            //     'comment' => '月結45天',
            //     'value'   => '',
            // ],
            // [
            //     'class'   => 'pay_ways',
            //     'code'    => 'A03',
            //     'comment' => '月結60天',
            //     'value'   => '',
            // ],
            // [
            //     'class'   => 'pay_ways',
            //     'code'    => 'A04',
            //     'comment' => '月結90天',
            //     'value'   => '',
            // ],
            // [
            //     'class'   => 'pay_ways',
            //     'code'    => 'CASH',
            //     'comment' => '現金',
            //     'value'   => '',
            // ],
            // [
            //     'class'   => 'pay_ways',
            //     'code'    => 'T/T',
            //     'comment' => '電匯',
            //     'value'   => '',
            // ],
        ]);
    }
}
