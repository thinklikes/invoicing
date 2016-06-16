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
                'level'      => 0,
                'namespace'  => '',
                'action'     => 'PageController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '基本資料管理',
                'level'      => 1,
                'namespace'  => '',
                'action'     => 'PageController@basic',
                'enabled'    => 1,
            ],
            [
                'name'       => '客戶資料管理',
                'level'      => 2,
                'namespace'  => 'Basic',
                'action'     => 'CustomerController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增單筆客戶資料',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'CustomerController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視單筆客戶資料',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'CustomerController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護單筆客戶資料',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'CustomerController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '供應商資料管理',
                'level'      => 2,
                'namespace'  => 'Basic',
                'action'     => 'SupplierController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增單筆供應商資料',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'SupplierController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視單筆供應商資料',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'SupplierController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護單筆供應商資料',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'SupplierController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '料品資料管理',
                'level'      => 2,
                'namespace'  => 'Basic',
                'action'     => 'StockController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增單筆料品資料',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'StockController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視單筆料品資料',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'StockController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護單筆料品資料',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'StockController@edit',
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
                'namespace'  => 'Basic',
                'action'     => 'UnitController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增料品單位資料',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'UnitController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視料品單位資料',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'UnitController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護料品單位資料',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'UnitController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '料品類別管理',
                'level'      => 2,
                'namespace'  => 'Basic',
                'action'     => 'StockClassController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增料品類別資料',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'StockClassController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視料品類別資料',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'StockClassController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護料品類別資料',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'StockClassController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '付款方式管理',
                'level'      => 2,
                'namespace'  => 'Basic',
                'action'     => 'PayWayController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增單筆付款方式',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'PayWayController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視單筆付款方式',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'PayWayController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護單筆付款方式',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'PayWayController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '倉庫資料管理',
                'level'      => 2,
                'namespace'  => 'Basic',
                'action'     => 'WarehouseController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增單筆倉庫資料',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'WarehouseController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視單筆倉庫資料',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'WarehouseController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護單筆倉庫資料',
                'level'      => 3,
                'namespace'  => 'Basic',
                'action'     => 'WarehouseController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '進貨作業',
                'level'      => 1,
                'namespace'  => '',
                'action'     => 'PageController@purchase',
                'enabled'    => 1,
            ],
            [
                'name'       => '採購單管理',
                'level'      => 2,
                'namespace'  => '',
                'action'     => 'PurchaseOrderController@index',
                'enabled'    => 0,
            ],
            [
                'name'       => '新增採購單據',
                'level'      => 3,
                'namespace'  => '',
                'action'     => 'PurchaseOrderController@create',
                'enabled'    => 0,
            ],
            [
                'name'       => '檢視採購單據',
                'level'      => 3,
                'namespace'  => '',
                'action'     => 'PurchaseOrderController@show',
                'enabled'    => 0,
            ],
            [
                'name'       => '維護採購單據',
                'level'      => 3,
                'namespace'  => '',
                'action'     => 'PurchaseOrderController@edit',
                'enabled'    => 0,
            ],
            [
                'name'       => '進貨單管理',
                'level'      => 2,
                'namespace'  => 'Purchase',
                'action'     => 'BillOfPurchaseController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增進貨單據',
                'level'      => 3,
                'namespace'  => 'Purchase',
                'action'     => 'BillOfPurchaseController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視進貨單據',
                'level'      => 3,
                'namespace'  => 'Purchase',
                'action'     => 'BillOfPurchaseController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護進貨單據',
                'level'      => 3,
                'namespace'  => 'Purchase',
                'action'     => 'BillOfPurchaseController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '進貨退回單管理',
                'level'      => 2,
                'namespace'  => '',
                'action'     => 'ReturnOfPurchaseController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增進貨退回單據',
                'level'      => 3,
                'namespace'  => '',
                'action'     => 'ReturnOfPurchaseController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視進貨退回單據',
                'level'      => 3,
                'namespace'  => '',
                'action'     => 'ReturnOfPurchaseController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護進貨退回單據',
                'level'      => 3,
                'namespace'  => '',
                'action'     => 'ReturnOfPurchaseController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '銷貨作業',
                'level'      => 1,
                'namespace'  => '',
                'action'     => 'PageController@sale',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增銷貨單據',
                'level'      => 2,
                'namespace'  => '',
                'action'     => 'SaleController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視銷貨單據',
                'level'      => 2,
                'namespace'  => '',
                'action'     => 'SaleController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護銷貨單據',
                'level'      => 2,
                'namespace'  => '',
                'action'     => 'SaleController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '系統設定',
                'level'      => 1,
                'namespace'  => '',
                'action'     => 'SystemConfigController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護系統設定',
                'level'      => 2,
                'namespace'  => '',
                'action'     => 'SystemConfigController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '更新系統設定',
                'level'      => 2,
                'namespace'  => '',
                'action'     => 'SystemConfigController@update',
                'enabled'    => 1,
            ]

        ];
        // make page code
        $i = 0;
        foreach ($pages as $key => $page) {
            switch ($page['level']) {
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
