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
            ['code' => '0'      , 'name' => '首頁', 'level' => -1, 'action' => 'PageController@portal', 'enabled' => 1],
            ['code' => '1'      , 'name' => '進銷存首頁', 'level' => 0, 'action' => 'PageController@index', 'enabled' => 1],
            ['code' => '101'    , 'name' => '基本資料管理', 'level' => 1, 'action' => 'PageController@basic', 'enabled' => 1],
            ['code' => '10101'  , 'name' => '客戶資料管理', 'level' => 2, 'action' => 'Basic\CompanyController@index', 'enabled' => 1],
            ['code' => '1010101', 'name' => '新增單筆客戶資料', 'level' => 3, 'action' => 'Basic\CompanyController@create', 'enabled' => 1],
            ['code' => '1010102', 'name' => '存入單筆客戶資料', 'level' => 3, 'action' => 'Basic\CompanyController@store', 'enabled' => 1],
            ['code' => '1010103', 'name' => '檢視單筆客戶資料', 'level' => 3, 'action' => 'Basic\CompanyController@show', 'enabled' => 1],
            ['code' => '1010104', 'name' => '維護單筆客戶資料', 'level' => 3, 'action' => 'Basic\CompanyController@edit', 'enabled' => 1],
            ['code' => '1010105', 'name' => '更新單筆客戶資料', 'level' => 3, 'action' => 'Basic\CompanyController@update', 'enabled' => 1],
            ['code' => '1010106', 'name' => '刪除單筆客戶資料', 'level' => 3, 'action' => 'Basic\CompanyController@destroy', 'enabled' => 1],
            ['code' => '10102'  , 'name' => '供應商資料管理', 'level' => 2, 'action' => 'Basic\SupplierController@index', 'enabled' => 1],
            ['code' => '1010201', 'name' => '新增單筆供應商資料', 'level' => 3, 'action' => 'Basic\SupplierController@create', 'enabled' => 1],
            ['code' => '1010202', 'name' => '存入單筆供應商資料', 'level' => 3, 'action' => 'Basic\SupplierController@store', 'enabled' => 1],
            ['code' => '1010203', 'name' => '檢視單筆供應商資料', 'level' => 3, 'action' => 'Basic\SupplierController@show', 'enabled' => 1],
            ['code' => '1010204', 'name' => '維護單筆供應商資料', 'level' => 3, 'action' => 'Basic\SupplierController@edit', 'enabled' => 1],
            ['code' => '1010205', 'name' => '更新單筆供應商資料', 'level' => 3, 'action' => 'Basic\SupplierController@update', 'enabled' => 1],
            ['code' => '1010206', 'name' => '刪除單筆供應商資料', 'level' => 3, 'action' => 'Basic\SupplierController@destroy', 'enabled' => 1],
            ['code' => '10103', 'name' => '料品資料管理', 'level' => 2, 'action' => 'Basic\StockController@index', 'enabled' => 1],
            ['code' => '1010301', 'name' => '新增單筆料品資料', 'level' => 3, 'action' => 'Basic\StockController@create', 'enabled' => 1],
            ['code' => '1010302', 'name' => '存入單筆料品資料', 'level' => 3, 'action' => 'Basic\StockController@store', 'enabled' => 1],
            ['code' => '1010303', 'name' => '檢視單筆料品資料', 'level' => 3, 'action' => 'Basic\StockController@show', 'enabled' => 1],
            ['code' => '1010304', 'name' => '維護單筆料品資料', 'level' => 3, 'action' => 'Basic\StockController@edit', 'enabled' => 1],
            ['code' => '1010305', 'name' => '更新單筆料品資料', 'level' => 3, 'action' => 'Basic\StockController@update', 'enabled' => 1],
            ['code' => '1010306', 'name' => '刪除單筆料品資料', 'level' => 3, 'action' => 'Basic\StockController@destroy', 'enabled' => 1],
            ['code' => '10104'  , 'name' => '料品單位管理', 'level' => 2, 'action' => 'Basic\UnitController@index', 'enabled' => 1],
            ['code' => '1010401', 'name' => '新增料品單位資料', 'level' => 3, 'action' => 'Basic\UnitController@create', 'enabled' => 1],
            ['code' => '1010402', 'name' => '存入料品單位資料', 'level' => 3, 'action' => 'Basic\UnitController@store', 'enabled' => 1],
            ['code' => '1010403', 'name' => '檢視料品單位資料', 'level' => 3, 'action' => 'Basic\UnitController@show', 'enabled' => 1],
            ['code' => '1010404', 'name' => '維護料品單位資料', 'level' => 3, 'action' => 'Basic\UnitController@edit', 'enabled' => 1],
            ['code' => '1010405', 'name' => '更新料品單位資料', 'level' => 3, 'action' => 'Basic\UnitController@update', 'enabled' => 1],
            ['code' => '1010406', 'name' => '刪除料品單位資料', 'level' => 3, 'action' => 'Basic\UnitController@destroy', 'enabled' => 1],
            ['code' => '10105'  , 'name' => '料品類別管理', 'level' => 2, 'action' => 'Basic\StockClassController@index', 'enabled' => 1],
            ['code' => '1010501', 'name' => '新增料品類別資料', 'level' => 3, 'action' => 'Basic\StockClassController@create', 'enabled' => 1],
            ['code' => '1010502', 'name' => '存入料品類別資料', 'level' => 3, 'action' => 'Basic\StockClassController@store', 'enabled' => 1],
            ['code' => '1010503', 'name' => '檢視料品類別資料', 'level' => 3, 'action' => 'Basic\StockClassController@show', 'enabled' => 1],
            ['code' => '1010504', 'name' => '維護料品類別資料', 'level' => 3, 'action' => 'Basic\StockClassController@edit', 'enabled' => 1],
            ['code' => '1010505', 'name' => '更新料品類別資料', 'level' => 3, 'action' => 'Basic\StockClassController@update', 'enabled' => 1],
            ['code' => '1010506', 'name' => '刪除料品類別資料', 'level' => 3, 'action' => 'Basic\StockClassController@destroy', 'enabled' => 1],
            ['code' => '10106'  , 'name' => '付款方式管理', 'level' => 2, 'action' => 'Basic\PayWayController@index', 'enabled' => 1],
            ['code' => '1010601', 'name' => '新增單筆付款方式', 'level' => 3, 'action' => 'Basic\PayWayController@create', 'enabled' => 1],
            ['code' => '1010602', 'name' => '存入單筆付款方式', 'level' => 3, 'action' => 'Basic\PayWayController@store', 'enabled' => 1],
            ['code' => '1010603', 'name' => '檢視單筆付款方式', 'level' => 3, 'action' => 'Basic\PayWayController@show', 'enabled' => 1],
            ['code' => '1010604', 'name' => '維護單筆付款方式', 'level' => 3, 'action' => 'Basic\PayWayController@edit', 'enabled' => 1],
            ['code' => '1010605', 'name' => '更新單筆付款方式', 'level' => 3, 'action' => 'Basic\PayWayController@update', 'enabled' => 1],
            ['code' => '1010606', 'name' => '刪除單筆付款方式', 'level' => 3, 'action' => 'Basic\PayWayController@destroy', 'enabled' => 1],
            ['code' => '10107'  , 'name' => '倉庫資料管理', 'level' => 2, 'action' => 'Basic\WarehouseController@index', 'enabled' => 1],
            ['code' => '1010701', 'name' => '新增單筆倉庫資料', 'level' => 3, 'action' => 'Basic\WarehouseController@create', 'enabled' => 1],
            ['code' => '1010702', 'name' => '存入單筆倉庫資料', 'level' => 3, 'action' => 'Basic\WarehouseController@store', 'enabled' => 1],
            ['code' => '1010703', 'name' => '檢視單筆倉庫資料', 'level' => 3, 'action' => 'Basic\WarehouseController@show', 'enabled' => 1],
            ['code' => '1010704', 'name' => '維護單筆倉庫資料', 'level' => 3, 'action' => 'Basic\WarehouseController@edit', 'enabled' => 1],
            ['code' => '1010705', 'name' => '更新單筆倉庫資料', 'level' => 3, 'action' => 'Basic\WarehouseController@update', 'enabled' => 1],
            ['code' => '1010706', 'name' => '刪除單筆倉庫資料', 'level' => 3, 'action' => 'Basic\WarehouseController@destroy', 'enabled' => 1],
            ['code' => '102'    , 'name' => '進貨作業', 'level' => 1, 'action' => 'PageController@purchase', 'enabled' => 1],
            ['code' => '10201'  , 'name' => '採購單管理', 'level' => 2, 'action' => 'PurchaseOrderController@index', 'enabled' => 0],
            ['code' => '1020101', 'name' => '新增採購單據', 'level' => 3, 'action' => 'PurchaseOrderController@create', 'enabled' => 0],
            ['code' => '1020102', 'name' => '存入採購單據', 'level' => 3, 'action' => 'PurchaseOrderController@store', 'enabled' => 0],
            ['code' => '1020103', 'name' => '檢視採購單據', 'level' => 3, 'action' => 'PurchaseOrderController@show', 'enabled' => 0],
            ['code' => '1020104', 'name' => '維護採購單據', 'level' => 3, 'action' => 'PurchaseOrderController@edit', 'enabled' => 0],
            ['code' => '1020105', 'name' => '更新採購單據', 'level' => 3, 'action' => 'PurchaseOrderController@update', 'enabled' => 0],
            ['code' => '1020106', 'name' => '刪除採購單據', 'level' => 3, 'action' => 'PurchaseOrderController@destroy', 'enabled' => 0],
            ['code' => '10202'  , 'name' => '進貨單管理', 'level' => 2, 'action' => 'Purchase\BillOfPurchaseController@index', 'enabled' => 1],
            ['code' => '1020201', 'name' => '新增進貨單據', 'level' => 3, 'action' => 'Purchase\BillOfPurchaseController@create', 'enabled' => 1],
            ['code' => '1020202', 'name' => '存入進貨單據', 'level' => 3, 'action' => 'Purchase\BillOfPurchaseController@store', 'enabled' => 1],
            ['code' => '1020203', 'name' => '檢視進貨單據', 'level' => 3, 'action' => 'Purchase\BillOfPurchaseController@show', 'enabled' => 1],
            ['code' => '1020204', 'name' => '維護進貨單據', 'level' => 3, 'action' => 'Purchase\BillOfPurchaseController@edit', 'enabled' => 1],
            ['code' => '1020205', 'name' => '更新進貨單據', 'level' => 3, 'action' => 'Purchase\BillOfPurchaseController@update', 'enabled' => 1],
            ['code' => '1020206', 'name' => '刪除進貨單據', 'level' => 3, 'action' => 'Purchase\BillOfPurchaseController@destroy', 'enabled' => 1],
            ['code' => '10203'  , 'name' => '進貨退回單管理', 'level' => 2, 'action' => 'Purchase\ReturnOfPurchaseController@index', 'enabled' => 1],
            ['code' => '1020301', 'name' => '新增進貨退回單據', 'level' => 3, 'action' => 'Purchase\ReturnOfPurchaseController@create', 'enabled' => 1],
            ['code' => '1020302', 'name' => '存入進貨退回單據', 'level' => 3, 'action' => 'Purchase\ReturnOfPurchaseController@store', 'enabled' => 1],
            ['code' => '1020303', 'name' => '檢視進貨退回單據', 'level' => 3, 'action' => 'Purchase\ReturnOfPurchaseController@show', 'enabled' => 1],
            ['code' => '1020304', 'name' => '維護進貨退回單據', 'level' => 3, 'action' => 'Purchase\ReturnOfPurchaseController@edit', 'enabled' => 1],
            ['code' => '1020305', 'name' => '更新進貨退回單據', 'level' => 3, 'action' => 'Purchase\ReturnOfPurchaseController@update', 'enabled' => 1],
            ['code' => '1020306', 'name' => '刪除進貨退回單據', 'level' => 3, 'action' => 'Purchase\ReturnOfPurchaseController@destroy', 'enabled' => 1],
            ['code' => '10204'  , 'name' => '付款單管理', 'level' => 2, 'action' => 'Purchase\PaymentController@index', 'enabled' => 1],
            ['code' => '1020401', 'name' => '新增付款單', 'level' => 3, 'action' => 'Purchase\PaymentController@create', 'enabled' => 1],
            ['code' => '1020402', 'name' => '存入付款單', 'level' => 3, 'action' => 'Purchase\PaymentController@store', 'enabled' => 1],
            ['code' => '1020403', 'name' => '檢視付款單', 'level' => 3, 'action' => 'Purchase\PaymentController@show', 'enabled' => 1],
            ['code' => '1020404', 'name' => '維護付款單', 'level' => 3, 'action' => 'Purchase\PaymentController@edit', 'enabled' => 1],
            ['code' => '1020405', 'name' => '更新付款單', 'level' => 3, 'action' => 'Purchase\PaymentController@update', 'enabled' => 1],
            ['code' => '1020406', 'name' => '刪除付款單', 'level' => 3, 'action' => 'Purchase\PaymentController@destroy', 'enabled' => 1],
            ['code' => '10205'  , 'name' => '應付帳款沖銷單管理', 'level' => 2, 'action' => 'Purchase\PayableWriteOffController@index', 'enabled' => 1],
            ['code' => '1020501', 'name' => '新增應付帳款沖銷單', 'level' => 3, 'action' => 'Purchase\PayableWriteOffController@create', 'enabled' => 1],
            ['code' => '1020502', 'name' => '存入應付帳款沖銷單', 'level' => 3, 'action' => 'Purchase\PayableWriteOffController@store', 'enabled' => 1],
            ['code' => '1020503', 'name' => '檢視應付帳款沖銷單', 'level' => 3, 'action' => 'Purchase\PayableWriteOffController@show', 'enabled' => 1],
            ['code' => '1020504', 'name' => '維護應付帳款沖銷單', 'level' => 3, 'action' => 'Purchase\PayableWriteOffController@edit', 'enabled' => 1],
            ['code' => '1020505', 'name' => '更新應付帳款沖銷單', 'level' => 3, 'action' => 'Purchase\PayableWriteOffController@update', 'enabled' => 1],
            ['code' => '1020506', 'name' => '刪除應付帳款沖銷單', 'level' => 3, 'action' => 'Purchase\PayableWriteOffController@destroy', 'enabled' => 1],
            ['code' => '103'    , 'name' => '銷貨作業', 'level' => 1, 'action' => 'PageController@sale', 'enabled' => 1],
            ['code' => '10301'  , 'name' => '訂購單管理', 'level' => 2, 'action' => 'SaleOrderController@index', 'enabled' => 0],
            ['code' => '1030101', 'name' => '新增訂購單據', 'level' => 3, 'action' => 'SaleOrderController@create', 'enabled' => 0],
            ['code' => '1030102', 'name' => '存入訂購單據', 'level' => 3, 'action' => 'SaleOrderController@store', 'enabled' => 0],
            ['code' => '1030103', 'name' => '檢視訂購單據', 'level' => 3, 'action' => 'SaleOrderController@show', 'enabled' => 0],
            ['code' => '1030104', 'name' => '維護訂購單據', 'level' => 3, 'action' => 'SaleOrderController@edit', 'enabled' => 0],
            ['code' => '1030105', 'name' => '更新訂購單據', 'level' => 3, 'action' => 'SaleOrderController@update', 'enabled' => 0],
            ['code' => '1030106', 'name' => '刪除訂購單據', 'level' => 3, 'action' => 'SaleOrderController@destroy', 'enabled' => 0],
            ['code' => '10302'  , 'name' => '銷貨單管理', 'level' => 2, 'action' => 'Sale\BillOfSaleController@index', 'enabled' => 1],
            ['code' => '1030201', 'name' => '新增銷貨單據', 'level' => 3, 'action' => 'Sale\BillOfSaleController@create', 'enabled' => 1],
            ['code' => '1030202', 'name' => '存入銷貨單據', 'level' => 3, 'action' => 'Sale\BillOfSaleController@store', 'enabled' => 1],
            ['code' => '1030203', 'name' => '檢視銷貨單據', 'level' => 3, 'action' => 'Sale\BillOfSaleController@show', 'enabled' => 1],
            ['code' => '1030204', 'name' => '維護銷貨單據', 'level' => 3, 'action' => 'Sale\BillOfSaleController@edit', 'enabled' => 1],
            ['code' => '1030205', 'name' => '更新銷貨單據', 'level' => 3, 'action' => 'Sale\BillOfSaleController@update', 'enabled' => 1],
            ['code' => '1030206', 'name' => '刪除銷貨單據', 'level' => 3, 'action' => 'Sale\BillOfSaleController@destroy', 'enabled' => 1],
            ['code' => '10303'  , 'name' => '銷貨退回單管理', 'level' => 2, 'action' => 'Sale\ReturnOfSaleController@index', 'enabled' => 1],
            ['code' => '1030301', 'name' => '新增銷貨退回單據', 'level' => 3, 'action' => 'Sale\ReturnOfSaleController@create', 'enabled' => 1],
            ['code' => '1030302', 'name' => '存入銷貨退回單據', 'level' => 3, 'action' => 'Sale\ReturnOfSaleController@store', 'enabled' => 1],
            ['code' => '1030303', 'name' => '檢視銷貨退回單據', 'level' => 3, 'action' => 'Sale\ReturnOfSaleController@show', 'enabled' => 1],
            ['code' => '1030304', 'name' => '維護銷貨退回單據', 'level' => 3, 'action' => 'Sale\ReturnOfSaleController@edit', 'enabled' => 1],
            ['code' => '1030305', 'name' => '更新銷貨退回單據', 'level' => 3, 'action' => 'Sale\ReturnOfSaleController@update', 'enabled' => 1],
            ['code' => '1030306', 'name' => '刪除銷貨退回單據', 'level' => 3, 'action' => 'Sale\ReturnOfSaleController@destroy', 'enabled' => 1],
            ['code' => '10304'  , 'name' => '銷貨日報表', 'level' => 2, 'action' => 'Sale\SaleReportController@index', 'enabled' => 1],
            ['code' => '10305'  , 'name' => '對帳單列印', 'level' => 2, 'action' => 'Sale\StatementController@index', 'enabled' => 1],
            ['code' => '10306'  , 'name' => '收款單管理', 'level' => 2, 'action' => 'Sale\ReceiptController@index', 'enabled' => 1],
            ['code' => '1030601', 'name' => '新增收款單', 'level' => 3, 'action' => 'Sale\ReceiptController@create', 'enabled' => 1],
            ['code' => '1030602', 'name' => '存入收款單', 'level' => 3, 'action' => 'Sale\ReceiptController@store', 'enabled' => 1],
            ['code' => '1030603', 'name' => '檢視收款單', 'level' => 3, 'action' => 'Sale\ReceiptController@show', 'enabled' => 1],
            ['code' => '1030604', 'name' => '維護收款單', 'level' => 3, 'action' => 'Sale\ReceiptController@edit', 'enabled' => 1],
            ['code' => '1030605', 'name' => '更新收款單', 'level' => 3, 'action' => 'Sale\ReceiptController@update', 'enabled' => 1],
            ['code' => '1030606', 'name' => '刪除收款單', 'level' => 3, 'action' => 'Sale\ReceiptController@destroy', 'enabled' => 1],
            ['code' => '10307'  , 'name' => '應收帳款沖銷單管理', 'level' => 2, 'action' => 'Sale\ReceivableWriteOffController@index', 'enabled' => 1],
            ['code' => '1030701', 'name' => '新增應收帳款沖銷單', 'level' => 3, 'action' => 'Sale\ReceivableWriteOffController@create', 'enabled' => 1],
            ['code' => '1030702', 'name' => '存入應收帳款沖銷單', 'level' => 3, 'action' => 'Sale\ReceivableWriteOffController@store', 'enabled' => 1],
            ['code' => '1030703', 'name' => '檢視應收帳款沖銷單', 'level' => 3, 'action' => 'Sale\ReceivableWriteOffController@show', 'enabled' => 1],
            ['code' => '1030704', 'name' => '維護應收帳款沖銷單', 'level' => 3, 'action' => 'Sale\ReceivableWriteOffController@edit', 'enabled' => 1],
            ['code' => '1030705', 'name' => '更新應收帳款沖銷單', 'level' => 3, 'action' => 'Sale\ReceivableWriteOffController@update', 'enabled' => 1],
            ['code' => '1030706', 'name' => '刪除應收帳款沖銷單', 'level' => 3, 'action' => 'Sale\ReceivableWriteOffController@destroy', 'enabled' => 1],
            ['code' => '104'    , 'name' => '存貨管理作業', 'level' => 1, 'action' => 'PageController@stockManager', 'enabled' => 1],
            ['code' => '10401'  , 'name' => '調整單管理', 'level' => 2, 'action' => 'StockManager\StockAdjustController@index', 'enabled' => 1],
            ['code' => '1040101', 'name' => '新增調整單', 'level' => 3, 'action' => 'StockManager\StockAdjustController@create', 'enabled' => 1],
            ['code' => '1040102', 'name' => '存入調整單', 'level' => 3, 'action' => 'StockManager\StockAdjustController@store', 'enabled' => 1],
            ['code' => '1040103', 'name' => '檢視調整單', 'level' => 3, 'action' => 'StockManager\StockAdjustController@show', 'enabled' => 1],
            ['code' => '1040104', 'name' => '維護調整單', 'level' => 3, 'action' => 'StockManager\StockAdjustController@edit', 'enabled' => 1],
            ['code' => '1040105', 'name' => '更新調整單', 'level' => 3, 'action' => 'StockManager\StockAdjustController@update', 'enabled' => 1],
            ['code' => '1040106', 'name' => '刪除調整單', 'level' => 3, 'action' => 'StockManager\StockAdjustController@destroy', 'enabled' => 1],
            ['code' => '10402'  , 'name' => '轉倉單管理', 'level' => 2, 'action' => 'StockManager\StockTransferController@index', 'enabled' => 1],
            ['code' => '1040201', 'name' => '新增轉倉單', 'level' => 3, 'action' => 'StockManager\StockTransferController@create', 'enabled' => 1],
            ['code' => '1040202', 'name' => '存入轉倉單', 'level' => 3, 'action' => 'StockManager\StockTransferController@store', 'enabled' => 1],
            ['code' => '1040203', 'name' => '檢視轉倉單', 'level' => 3, 'action' => 'StockManager\StockTransferController@show', 'enabled' => 1],
            ['code' => '1040204', 'name' => '維護轉倉單', 'level' => 3, 'action' => 'StockManager\StockTransferController@edit', 'enabled' => 1],
            ['code' => '1040205', 'name' => '更新轉倉單', 'level' => 3, 'action' => 'StockManager\StockTransferController@update', 'enabled' => 1],
            ['code' => '1040206', 'name' => '刪除轉倉單', 'level' => 3, 'action' => 'StockManager\StockTransferController@destroy', 'enabled' => 1],
            ['code' => '10403'  , 'name' => '庫存異動表', 'level' => 2, 'action' => 'StockManager\StockInOutReportController@index', 'enabled' => 1],
            ['code' => '1040301', 'name' => '庫存異動表-列出查詢結果', 'level' => 3, 'action' => 'StockManager\StockInOutReportController@show', 'enabled' => 1],
            ['code' => '105'    , 'name' => '系統', 'level' => 1, 'action' => 'PageController@system', 'enabled' => 1],
            ['code' => '10501'  , 'name' => '系統參數設定', 'level' => 2, 'action' => 'Basic\SystemConfigController@index', 'enabled' => 1],
            ['code' => '1050101', 'name' => '維護系統參數', 'level' => 3, 'action' => 'Basic\SystemConfigController@edit', 'enabled' => 1],
            ['code' => '1050102', 'name' => '更新系統參數', 'level' => 3, 'action' => 'Basic\SystemConfigController@update', 'enabled' => 1],
            ['code' => '10502'  , 'name' => '使用者資料管理', 'level' => 2, 'action' => 'Erp\CRUDController@index', 'enabled' => 1],
            ['code' => '1050201', 'name' => '新增使用者資料', 'level' => 3, 'action' => 'Erp\CRUDController@create', 'enabled' => 1],
            ['code' => '1050202', 'name' => '存入使用者資料', 'level' => 3, 'action' => 'Erp\CRUDController@store', 'enabled' => 1],
            ['code' => '1050203', 'name' => '檢視使用者資料', 'level' => 3, 'action' => 'Erp\CRUDController@show', 'enabled' => 1],
            ['code' => '1050204', 'name' => '維護使用者資料', 'level' => 3, 'action' => 'Erp\CRUDController@edit', 'enabled' => 1],
            ['code' => '1050205', 'name' => '更新使用者資料', 'level' => 3, 'action' => 'Erp\CRUDController@update', 'enabled' => 1],
            ['code' => '1050206', 'name' => '刪除使用者資料', 'level' => 3, 'action' => 'Erp\CRUDController@destroy', 'enabled' => 1],
            ['code' => '1050401', 'name' => '資料備份匯出', 'level' => 2, 'action' => 'Basic\SystemConfigController@exportSettings', 'enabled' => 1],
            ['code' => '10505', 'name' => '資料備份匯入', 'level' => 2, 'action' => 'Basic\SystemConfigController@importSettings', 'enabled' => 1],
            ['code' => '10506', 'name' => '系統更新記錄', 'level' => 2, 'action' => 'Basic\SystemConfigController@updateLogs', 'enabled' => 1]
        ];

        DB::table('erp_pages')->truncate();
        DB::table('erp_pages')->insert($pages);
    }
}
