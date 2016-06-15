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
                'action'     => 'PageController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '基本資料管理',
                'level'      => 1,
                'action'     => 'PageController@base',
                'enabled'    => 1,
            ],
            [
                'name'       => '客戶資料管理',
                'level'      => 2,
                'action'     => 'CustomerController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增單筆客戶資料',
                'level'      => 3,
                'action'     => 'CustomerController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視單筆客戶資料',
                'level'      => 3,
                'action'     => 'CustomerController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護單筆客戶資料',
                'level'      => 3,
                'action'     => 'CustomerController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '供應商資料管理',
                'level'      => 2,
                'action'     => 'SupplierController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增單筆供應商資料',
                'level'      => 3,
                'action'     => 'SupplierController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視單筆供應商資料',
                'level'      => 3,
                'action'     => 'SupplierController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護單筆供應商資料',
                'level'      => 3,
                'action'     => 'SupplierController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '料品資料管理',
                'level'      => 2,
                'action'     => 'StockController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增單筆料品資料',
                'level'      => 3,
                'action'     => 'StockController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視單筆料品資料',
                'level'      => 3,
                'action'     => 'StockController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護單筆料品資料',
                'level'      => 3,
                'action'     => 'StockController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '稅別資料管理',
                'level'      => 2,
                'action'     => 'TaxRateController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增單筆稅別資料',
                'level'      => 3,
                'action'     => 'TaxRateController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視單筆稅別資料',
                'level'      => 3,
                'action'     => 'TaxRateController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護單筆稅別資料',
                'level'      => 3,
                'action'     => 'TaxRateController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '料品單位管理',
                'level'      => 2,
                'action'     => 'UnitController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增料品單位資料',
                'level'      => 3,
                'action'     => 'UnitController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視料品單位資料',
                'level'      => 3,
                'action'     => 'UnitController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護料品單位資料',
                'level'      => 3,
                'action'     => 'UnitController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '料品類別管理',
                'level'      => 2,
                'action'     => 'StockClassController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增料品類別資料',
                'level'      => 3,
                'action'     => 'StockClassController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視料品類別資料',
                'level'      => 3,
                'action'     => 'StockClassController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護料品類別資料',
                'level'      => 3,
                'action'     => 'StockClassController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '付款方式管理',
                'level'      => 2,
                'action'     => 'PayWayController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增單筆付款方式',
                'level'      => 3,
                'action'     => 'PayWayController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視單筆付款方式',
                'level'      => 3,
                'action'     => 'PayWayController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護單筆付款方式',
                'level'      => 3,
                'action'     => 'PayWayController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '倉庫資料管理',
                'level'      => 2,
                'action'     => 'WarehouseController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增單筆倉庫資料',
                'level'      => 3,
                'action'     => 'WarehouseController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視單筆倉庫資料',
                'level'      => 3,
                'action'     => 'WarehouseController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護單筆倉庫資料',
                'level'      => 3,
                'action'     => 'WarehouseController@edit',
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
                'action'     => 'ReturnOfPurchaseController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增進貨退回單據',
                'level'      => 3,
                'action'     => 'ReturnOfPurchaseController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視進貨退回單據',
                'level'      => 3,
                'action'     => 'ReturnOfPurchaseController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護進貨退回單據',
                'level'      => 3,
                'action'     => 'ReturnOfPurchaseController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '銷貨作業',
                'level'      => 1,
                'action'     => 'PageController@sale',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增銷貨單據',
                'level'      => 2,
                'action'     => 'SaleController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視銷貨單據',
                'level'      => 2,
                'action'     => 'SaleController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護銷貨單據',
                'level'      => 2,
                'action'     => 'SaleController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '系統設定',
                'level'      => 1,
                'action'     => 'SystemConfigController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護系統設定',
                'level'      => 2,
                'action'     => 'SystemConfigController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '更新系統設定',
                'level'      => 2,
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
