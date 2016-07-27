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
                'enabled'    => 0,
            ],
            [
                'name'       => '新增單筆客戶資料',
                'level'      => 3,
                'action'     => 'Basic\CustomerController@create',
                'enabled'    => 0,
            ],
            [
                'name'       => '檢視單筆客戶資料',
                'level'      => 3,
                'action'     => 'Basic\CustomerController@show',
                'enabled'    => 0,
            ],
            [
                'name'       => '維護單筆客戶資料',
                'level'      => 3,
                'action'     => 'Basic\CustomerController@edit',
                'enabled'    => 0,
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
            [
                'name'       => '銷貨作業',
                'level'      => 1,
                'action'     => 'PageController@sale',
                'enabled'    => 1,
            ],
            [
                'name'       => '訂購單管理',
                'level'      => 2,
                'action'     => 'SaleOrderController@index',
                'enabled'    => 0,
            ],
            [
                'name'       => '新增訂購單據',
                'level'      => 3,
                'action'     => 'SaleOrderController@create',
                'enabled'    => 0,
            ],
            [
                'name'       => '檢視訂購單據',
                'level'      => 3,
                'action'     => 'SaleOrderController@show',
                'enabled'    => 0,
            ],
            [
                'name'       => '維護訂購單據',
                'level'      => 3,
                'action'     => 'SaleOrderController@edit',
                'enabled'    => 0,
            ],
            [
                'name'       => '銷貨單管理',
                'level'      => 2,
                'action'     => 'Sale\BillOfSaleController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增銷貨單據',
                'level'      => 3,
                'action'     => 'Sale\BillOfSaleController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視銷貨單據',
                'level'      => 3,
                'action'     => 'Sale\BillOfSaleController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護銷貨單據',
                'level'      => 3,
                'action'     => 'Sale\BillOfSaleController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '銷貨退回單管理',
                'level'      => 2,
                'action'     => 'Sale\ReturnOfSaleController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增銷貨退回單據',
                'level'      => 3,
                'action'     => 'Sale\ReturnOfSaleController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視銷貨退回單據',
                'level'      => 3,
                'action'     => 'Sale\ReturnOfSaleController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護銷貨退回單據',
                'level'      => 3,
                'action'     => 'Sale\ReturnOfSaleController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '銷貨日報表',
                'level'      => 2,
                'action'     => 'Sale\SaleReportController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '對帳單列印',
                'level'      => 2,
                'action'     => 'Sale\StatementController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '收款單管理',
                'level'      => 2,
                'action'     => 'Sale\ReceiptController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增收款單',
                'level'      => 3,
                'action'     => 'Sale\ReceiptController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視收款單',
                'level'      => 3,
                'action'     => 'Sale\ReceiptController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護收款單',
                'level'      => 3,
                'action'     => 'Sale\ReceiptController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '應收帳款沖銷單管理',
                'level'      => 2,
                'action'     => 'Sale\ReceivableWriteOffController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增應收帳款沖銷單',
                'level'      => 3,
                'action'     => 'Sale\ReceivableWriteOffController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視應收帳款沖銷單',
                'level'      => 3,
                'action'     => 'Sale\ReceivableWriteOffController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護應收帳款沖銷單',
                'level'      => 3,
                'action'     => 'Sale\ReceivableWriteOffController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '存貨管理作業',
                'level'      => 1,
                'action'     => 'PageController@stockManager',
                'enabled'    => 1,
            ],
            [
                'name'       => '調整單管理',
                'level'      => 2,
                'action'     => 'StockManager\StockAdjustController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增調整單',
                'level'      => 3,
                'action'     => 'StockManager\StockAdjustController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視調整單',
                'level'      => 3,
                'action'     => 'StockManager\StockAdjustController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護調整單',
                'level'      => 3,
                'action'     => 'StockManager\StockAdjustController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '轉倉單管理',
                'level'      => 2,
                'action'     => 'StockManager\StockTransferController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '新增轉倉單',
                'level'      => 3,
                'action'     => 'StockManager\StockTransferController@create',
                'enabled'    => 1,
            ],
            [
                'name'       => '檢視轉倉單',
                'level'      => 3,
                'action'     => 'StockManager\StockTransferController@show',
                'enabled'    => 1,
            ],
            [
                'name'       => '維護轉倉單',
                'level'      => 3,
                'action'     => 'StockManager\StockTransferController@edit',
                'enabled'    => 1,
            ],
            [
                'name'       => '庫存異動表',
                'level'      => 2,
                'action'     => 'StockManager\StockInOutReportController@index',
                'enabled'    => 1,
            ],
            [
                'name'       => '庫存異動表-列出查詢結果',
                'level'      => 3,
                'action'     => 'StockManager\StockInOutReportController@show',
                'enabled'    => 1,
            ],
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
        DB::table('erp_pages')->truncate();
        DB::table('erp_pages')->insert($pages);
    }
}
