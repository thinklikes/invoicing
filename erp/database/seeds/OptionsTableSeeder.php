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
        DB::table('erp_options')->insert([
            //網站基本資訊
            [
                'class'   => 'system_configs',
                'code'    => 'website_title',
                'comment' => '網站標題',
                'value'   => '好好公司',
            ],
            [
                'class'   => 'system_configs',
                'code'    => 'system_build_date',
                'comment' => '系統建立日期',
                'value'   => '2016-01-01',
            ],
            // [
            //     'class'   => 'system_configs',
            //     'code'    => 'purchase_order_format',
            //     'comment' => '採購單號格式',
            //     'value'   => 'YYYY-MM-DD',
            // ],
            [
                'class'   => 'system_configs',
                'code'    => 'purchase_tax_rate',
                'comment' => '進貨稅率',
                'value'   => '0.05',
            ],
            [
                'class'   => 'system_configs',
                'code'    => 'sale_tax_rate',
                'comment' => '銷貨稅率',
                'value'   => '0.05',
            ],
            [
                'class'   => 'system_configs',
                'code'    => 'quantity_round_off',
                'comment' => '數量小數點位數',
                'value'   => '2',
            ],
            [
                'class'   => 'system_configs',
                'code'    => 'no_tax_price_round_off',
                'comment' => '稅前單價小數點位數',
                'value'   => '2',
            ],
            [
                'class'   => 'system_configs',
                'code'    => 'no_tax_amount_round_off',
                'comment' => '小計小數點位數',
                'value'   => '2',
            ],
            [
                'class'   => 'system_configs',
                'code'    => 'tax_round_off',
                'comment' => '營業稅小數點位數',
                'value'   => '0',
            ],
            [
                'class'   => 'system_configs',
                'code'    => 'total_amount_round_off',
                'comment' => '總計小數點位數',
                'value'   => '0',
            ],
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
            [
                'class'   => 'pay_ways',
                'code'    => 'A01',
                'comment' => '月結30天',
                'value'   => '',
            ],
            [
                'class'   => 'pay_ways',
                'code'    => 'A02',
                'comment' => '月結45天',
                'value'   => '',
            ],
            [
                'class'   => 'pay_ways',
                'code'    => 'A03',
                'comment' => '月結60天',
                'value'   => '',
            ],
            [
                'class'   => 'pay_ways',
                'code'    => 'A04',
                'comment' => '月結90天',
                'value'   => '',
            ],
            [
                'class'   => 'pay_ways',
                'code'    => 'CASH',
                'comment' => '現金',
                'value'   => '',
            ],
            [
                'class'   => 'pay_ways',
                'code'    => 'T/T',
                'comment' => '電匯',
                'value'   => '',
            ],
        ]);
    }
}
