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
            [
                'class'   => 'system_configs',
                'code'    => 'company_name',
                'comment' => '公司名稱',
                'value'   => '好好公司',
            ],
            [
                'class'   => 'system_configs',
                'code'    => 'company_address',
                'comment' => '公司地址',
                'value'   => '高雄市鳥松區球場路21號',
            ],
            [
                'class'   => 'system_configs',
                'code'    => 'company_phone_number',
                'comment' => '公司電話',
                'value'   => '(07)3700050',
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
            [
                'class'   => 'discount',
                'code'    => '100%',
                'comment' => '不打折',
                'value'   => '1',
            ],
            [
                'class'   => 'discount',
                'code'    => '95%',
                'comment' => '95折',
                'value'   => '0.95',
            ],
            [
                'class'   => 'discount',
                'code'    => '90%',
                'comment' => '9折',
                'value'   => '0.9',
            ],
            [
                'class'   => 'discount',
                'code'    => '85%',
                'comment' => '85折',
                'value'   => '0.85',
            ],
            [
                'class'   => 'discount',
                'code'    => '80%',
                'comment' => '8折',
                'value'   => '0.8',
            ],
            [
                'class'   => 'discount',
                'code'    => '75%',
                'comment' => '75折',
                'value'   => '0.75',
            ],
            [
                'class'   => 'discount',
                'code'    => '70%',
                'comment' => '7折',
                'value'   => '0.7',
            ],
            [
                'class'   => 'discount',
                'code'    => '65%',
                'comment' => '65折',
                'value'   => '0.65',
            ],
            [
                'class'   => 'discount',
                'code'    => '60%',
                'comment' => '6折',
                'value'   => '0.6',
            ],
            [
                'class'   => 'discount',
                'code'    => '55%',
                'comment' => '55折',
                'value'   => '0.55',
            ],
            [
                'class'   => 'discount',
                'code'    => '50%',
                'comment' => '5折',
                'value'   => '0.5',
            ],
        ]);
    }
}
