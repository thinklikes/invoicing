<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $pages = [
            [
                'name'       => '首頁',
                'level'      => -1,
                'action'     => 'PageController@portal',
                'enabled'    => 1,
            ],
            [
                'name'       => '進銷存首頁',
                'level'      => 0,
                'action'     => 'PageController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '基本資料管理',
                'level'      => 1,
                'action'     => 'PageController@basic',
                'enabled'    => 1,
            ],
            [
                'name'       => '客戶資料管理',
                'level'      => 2,
                'action'     => 'Basic\CustomerController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增單筆客戶資料',
                'level'      => 3,
                'action'     => 'Basic\CustomerController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視單筆客戶資料',
                'level'      => 3,
                'action'     => 'Basic\CustomerController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護單筆客戶資料',
                'level'      => 3,
                'action'     => 'Basic\CustomerController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '供應商資料管理',
                'level'      => 2,
                'action'     => 'Basic\SupplierController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增單筆供應商資料',
                'level'      => 3,
                'action'     => 'Basic\SupplierController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視單筆供應商資料',
                'level'      => 3,
                'action'     => 'Basic\SupplierController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護單筆供應商資料',
                'level'      => 3,
                'action'     => 'Basic\SupplierController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '料品資料管理',
                'level'      => 2,
                'action'     => 'Basic\StockController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增單筆料品資料',
                'level'      => 3,
                'action'     => 'Basic\StockController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視單筆料品資料',
                'level'      => 3,
                'action'     => 'Basic\StockController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護單筆料品資料',
                'level'      => 3,
                'action'     => 'Basic\StockController@edit',
                'enabled'    => 1,
            ],
            // [
            //     'name'       => '稅別資料管理',
            //     'level'      => 2,
            //    'namespace'  => '',
            //     'action'     => 'TaxRateController@index',
            //     'enabled'    => 1,
            // ],
            // [
            //     'name'       => '新增單筆稅別資料',
            //     'level'      => 3,
            //    'namespace'  => '',
            //     'action'     => 'TaxRateController@create',
            //     'enabled'    => 1,
            // ],
            // [
            //     'name'       => '檢視單筆稅別資料',
            //     'level'      => 3,
            //    'namespace'  => '',
            //     'action'     => 'TaxRateController@show',
            //     'enabled'    => 1,
            // ],
            // [
            //     'name'       => '維護單筆稅別資料',
            //     'level'      => 3,
            //    'namespace'  => '',
            //     'action'     => 'TaxRateController@edit',
            //     'enabled'    => 1,
            // ],
            [
                'name'       => '料品單位管理',
                'level'      => 2,
                'action'     => 'Basic\UnitController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增料品單位資料',
                'level'      => 3,
                'action'     => 'Basic\UnitController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視料品單位資料',
                'level'      => 3,
                'action'     => 'Basic\UnitController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護料品單位資料',
                'level'      => 3,
                'action'     => 'Basic\UnitController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '料品類別管理',
                'level'      => 2,
                'action'     => 'Basic\StockClassController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增料品類別資料',
                'level'      => 3,
                'action'     => 'Basic\StockClassController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視料品類別資料',
                'level'      => 3,
                'action'     => 'Basic\StockClassController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護料品類別資料',
                'level'      => 3,
                'action'     => 'Basic\StockClassController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '付款方式管理',
                'level'      => 2,
                'action'     => 'Basic\PayWayController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增單筆付款方式',
                'level'      => 3,
                'action'     => 'Basic\PayWayController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視單筆付款方式',
                'level'      => 3,
                'action'     => 'Basic\PayWayController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護單筆付款方式',
                'level'      => 3,
                'action'     => 'Basic\PayWayController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '倉庫資料管理',
                'level'      => 2,
                'action'     => 'Basic\WarehouseController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增單筆倉庫資料',
                'level'      => 3,
                'action'     => 'Basic\WarehouseController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視單筆倉庫資料',
                'level'      => 3,
                'action'     => 'Basic\WarehouseController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護單筆倉庫資料',
                'level'      => 3,
                'action'     => 'Basic\WarehouseController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '進貨作業',
                'level'      => 1,
                'action'     => 'PageController@purchase',
                'enabled'    => 1,
            ],
            [
                'name'       => '採購單管理',
                'level'      => 2,
                'action'     => 'PurchaseOrderController@index',
                'enabled'    => 0,
            ],
            [
                'name'       => '新增採購單據',
                'level'      => 3,
                'action'     => 'PurchaseOrderController@create',
                'enabled'    => 0,
            ],
            [
                'name'       => '檢視採購單據',
                'level'      => 3,
                'action'     => 'PurchaseOrderController@show',
                'enabled'    => 0,
            ],
            [
                'name'       => '維護採購單據',
                'level'      => 3,
                'action'     => 'PurchaseOrderController@edit',
                'enabled'    => 0,
            ],
            [
                'name'       => '進貨單管理',
                'level'      => 2,
                'action'     => 'Purchase\BillOfPurchaseController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增進貨單據',
                'level'      => 3,
                'action'     => 'Purchase\BillOfPurchaseController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視進貨單據',
                'level'      => 3,
                'action'     => 'Purchase\BillOfPurchaseController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護進貨單據',
                'level'      => 3,
                'action'     => 'Purchase\BillOfPurchaseController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '進貨退回單管理',
                'level'      => 2,
                'action'     => 'Purchase\ReturnOfPurchaseController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增進貨退回單據',
                'level'      => 3,
                'action'     => 'Purchase\ReturnOfPurchaseController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視進貨退回單據',
                'level'      => 3,
                'action'     => 'Purchase\ReturnOfPurchaseController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護進貨退回單據',
                'level'      => 3,
                'action'     => 'Purchase\ReturnOfPurchaseController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '付款單管理',
                'level'      => 2,
                'action'     => 'Purchase\PaymentController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增付款單',
                'level'      => 3,
                'action'     => 'Purchase\PaymentController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視付款單',
                'level'      => 3,
                'action'     => 'Purchase\PaymentController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護付款單',
                'level'      => 3,
                'action'     => 'Purchase\PaymentController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '應付帳款沖銷單管理',
                'level'      => 2,
                'action'     => 'Purchase\PayableWriteOffController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增應付帳款沖銷單',
                'level'      => 3,
                'action'     => 'Purchase\PayableWriteOffController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視應付帳款沖銷單',
                'level'      => 3,
                'action'     => 'Purchase\PayableWriteOffController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護應付帳款沖銷單',
                'level'      => 3,
                'action'     => 'Purchase\PayableWriteOffController@edit',
                'enabled'    => 1,
            ],
            // [
            //     'name'       => '銷貨作業',
            //     'level'      => 1,
            //     'namespace'  => '',
            //     'action'     => 'PageController@sale',
            //     'enabled'    => 1,
            // ],
            // [
            //     'name'       => '新增銷貨單據',
            //     'level'      => 2,
            //     'namespace'  => '',
            //     'action'     => 'SaleController@create',
            //     'enabled'    => 1,
            // ],
            // [
            //     'name'       => '檢視銷貨單據',
            //     'level'      => 2,
            //     'namespace'  => '',
            //     'action'     => 'SaleController@show',
            //     'enabled'    => 1,
            // ],
            // [
            //     'name'       => '維護銷貨單據',
            //     'level'      => 2,
            //     'namespace'  => '',
            //     'action'     => 'SaleController@edit',
            //     'enabled'    => 1,
            // ],
            [
                'name'       => '系統設定',
                'level'      => 1,
                'action'     => 'Basic\SystemConfigController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護系統設定',
                'level'      => 2,
                'action'     => 'Basic\SystemConfigController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '更新系統設定',
                'level'      => 2,
                'action'     => 'Basic\SystemConfigController@update',
                'enabled'    => 1,
            ]

        ];
        // make page code
        $i = 0;
        foreach ($pages as $key => $page) {
            switch ($page['level']) {
                case -1:
                    $code = '0';
                    break;
                case 0:
                    $code = '1';
                    break;
                case 1:
                    $i ++;
                    $j = 0;
                    $code = '1'.sprintf('%02d', $i);
                    break;
                case 2:
                    $j ++;
                    $k = 0;
                    $code = '1'.sprintf('%02d%02d', $i, $j);
                    break;
                case 3:
                    $k ++;
                    $code = '1'.sprintf('%02d%02d%02d', $i, $j, $k);
                    break;
            }
            $pages[$key] = array_add($pages[$key], 'code', $code);
        }
        DB::table('pages')->insert($pages);
    }
}
