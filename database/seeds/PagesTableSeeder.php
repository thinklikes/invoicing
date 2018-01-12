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
            ['code' => '0'      , 'name' => '首頁', 'level' => -1, 'route_name' => 'portal', 'enabled' => 1],
            ['code' => '1'      , 'name' => '進銷存首頁', 'level' => 0, 'route_name' => 'menu::erp', 'enabled' => 1],
            ['code' => '101'    , 'name' => '基本資料管理', 'level' => 1, 'route_name' => 'menu::basic', 'enabled' => 1],
            ['code' => '10101'  , 'name' => '客戶資料管理', 'level' => 2, 'route_name' => 'company::index', 'enabled' => 1],
            ['code' => '1010101', 'name' => '新增單筆客戶資料', 'level' => 3, 'route_name' => 'company::create', 'enabled' => 1],
            ['code' => '1010102', 'name' => '存入單筆客戶資料', 'level' => 3, 'route_name' => 'company::store', 'enabled' => 1],
            ['code' => '1010103', 'name' => '檢視單筆客戶資料', 'level' => 3, 'route_name' => 'company::show', 'enabled' => 1],
            ['code' => '1010104', 'name' => '維護單筆客戶資料', 'level' => 3, 'route_name' => 'company::edit', 'enabled' => 1],
            ['code' => '1010105', 'name' => '更新單筆客戶資料', 'level' => 3, 'route_name' => 'company::update', 'enabled' => 1],
            ['code' => '1010106', 'name' => '刪除單筆客戶資料', 'level' => 3, 'route_name' => 'company::destroy', 'enabled' => 1],

            ['code' => '10102'  , 'name' => '供應商資料管理', 'level' => 2, 'route_name' => 'supplier::index', 'enabled' => 1],
            ['code' => '1010201', 'name' => '新增單筆供應商資料', 'level' => 3, 'route_name' => 'supplier::create', 'enabled' => 1],
            ['code' => '1010202', 'name' => '存入單筆供應商資料', 'level' => 3, 'route_name' => 'supplier::store', 'enabled' => 1],
            ['code' => '1010203', 'name' => '檢視單筆供應商資料', 'level' => 3, 'route_name' => 'supplier::show', 'enabled' => 1],
            ['code' => '1010204', 'name' => '維護單筆供應商資料', 'level' => 3, 'route_name' => 'supplier::edit', 'enabled' => 1],
            ['code' => '1010205', 'name' => '更新單筆供應商資料', 'level' => 3, 'route_name' => 'supplier::update', 'enabled' => 1],
            ['code' => '1010206', 'name' => '刪除單筆供應商資料', 'level' => 3, 'route_name' => 'supplier::destroy', 'enabled' => 1],

            ['code' => '10103', 'name' => '料品資料管理', 'level' => 2, 'route_name' => 'stock::index', 'enabled' => 1],
            ['code' => '1010301', 'name' => '新增單筆料品資料', 'level' => 3, 'route_name' => 'stock::create', 'enabled' => 1],
            ['code' => '1010302', 'name' => '存入單筆料品資料', 'level' => 3, 'route_name' => 'stock::store', 'enabled' => 1],
            ['code' => '1010303', 'name' => '檢視單筆料品資料', 'level' => 3, 'route_name' => 'stock::show', 'enabled' => 1],
            ['code' => '1010304', 'name' => '維護單筆料品資料', 'level' => 3, 'route_name' => 'stock::edit', 'enabled' => 1],
            ['code' => '1010305', 'name' => '更新單筆料品資料', 'level' => 3, 'route_name' => 'stock::update', 'enabled' => 1],
            ['code' => '1010306', 'name' => '刪除單筆料品資料', 'level' => 3, 'route_name' => 'stock::destroy', 'enabled' => 1],

            ['code' => '10104'  , 'name' => '料品單位管理', 'level' => 2, 'route_name' => 'unit::index', 'enabled' => 1],
            ['code' => '1010401', 'name' => '新增料品單位資料', 'level' => 3, 'route_name' => 'unit::create', 'enabled' => 1],
            ['code' => '1010402', 'name' => '存入料品單位資料', 'level' => 3, 'route_name' => 'unit::store', 'enabled' => 1],
            ['code' => '1010403', 'name' => '檢視料品單位資料', 'level' => 3, 'route_name' => 'unit::show', 'enabled' => 1],
            ['code' => '1010404', 'name' => '維護料品單位資料', 'level' => 3, 'route_name' => 'unit::edit', 'enabled' => 1],
            ['code' => '1010405', 'name' => '更新料品單位資料', 'level' => 3, 'route_name' => 'unit::update', 'enabled' => 1],
            ['code' => '1010406', 'name' => '刪除料品單位資料', 'level' => 3, 'route_name' => 'unit::destroy', 'enabled' => 1],

            ['code' => '10105'  , 'name' => '料品類別管理', 'level' => 2, 'route_name' => 'stockClass::index', 'enabled' => 1],
            ['code' => '1010501', 'name' => '新增料品類別資料', 'level' => 3, 'route_name' => 'stockClass::create', 'enabled' => 1],
            ['code' => '1010502', 'name' => '存入料品類別資料', 'level' => 3, 'route_name' => 'stockClass::store', 'enabled' => 1],
            ['code' => '1010503', 'name' => '檢視料品類別資料', 'level' => 3, 'route_name' => 'stockClass::show', 'enabled' => 1],
            ['code' => '1010504', 'name' => '維護料品類別資料', 'level' => 3, 'route_name' => 'stockClass::edit', 'enabled' => 1],
            ['code' => '1010505', 'name' => '更新料品類別資料', 'level' => 3, 'route_name' => 'stockClass::update', 'enabled' => 1],
            ['code' => '1010506', 'name' => '刪除料品類別資料', 'level' => 3, 'route_name' => 'stockClass::destroy', 'enabled' => 1],

            ['code' => '10106'  , 'name' => '付款方式管理', 'level' => 2, 'route_name' => 'payWay::index', 'enabled' => 1],
            ['code' => '1010601', 'name' => '新增單筆付款方式', 'level' => 3, 'route_name' => 'payWay::create', 'enabled' => 1],
            ['code' => '1010602', 'name' => '存入單筆付款方式', 'level' => 3, 'route_name' => 'payWay::store', 'enabled' => 1],
            ['code' => '1010603', 'name' => '檢視單筆付款方式', 'level' => 3, 'route_name' => 'payWay::show', 'enabled' => 1],
            ['code' => '1010604', 'name' => '維護單筆付款方式', 'level' => 3, 'route_name' => 'payWay::edit', 'enabled' => 1],
            ['code' => '1010605', 'name' => '更新單筆付款方式', 'level' => 3, 'route_name' => 'payWay::update', 'enabled' => 1],
            ['code' => '1010606', 'name' => '刪除單筆付款方式', 'level' => 3, 'route_name' => 'payWay::destroy', 'enabled' => 1],

            ['code' => '10107'  , 'name' => '倉庫資料管理', 'level' => 2, 'route_name' => 'warehouse::index', 'enabled' => 1],
            ['code' => '1010701', 'name' => '新增單筆倉庫資料', 'level' => 3, 'route_name' => 'warehouse::create', 'enabled' => 1],
            ['code' => '1010702', 'name' => '存入單筆倉庫資料', 'level' => 3, 'route_name' => 'warehouse::store', 'enabled' => 1],
            ['code' => '1010703', 'name' => '檢視單筆倉庫資料', 'level' => 3, 'route_name' => 'warehouse::show', 'enabled' => 1],
            ['code' => '1010704', 'name' => '維護單筆倉庫資料', 'level' => 3, 'route_name' => 'warehouse::edit', 'enabled' => 1],
            ['code' => '1010705', 'name' => '更新單筆倉庫資料', 'level' => 3, 'route_name' => 'warehouse::update', 'enabled' => 1],
            ['code' => '1010706', 'name' => '刪除單筆倉庫資料', 'level' => 3, 'route_name' => 'warehouse::destroy', 'enabled' => 1],

            ['code' => '102'    , 'name' => '進貨作業', 'level' => 1, 'route_name' => 'menu::purchase', 'enabled' => 1],
            ['code' => '10201'  , 'name' => '採購單管理', 'level' => 2, 'route_name' => 'purchaseOrder::@index', 'enabled' => 0],
            ['code' => '1020101', 'name' => '新增採購單據', 'level' => 3, 'route_name' => 'purchaseOrder::@create', 'enabled' => 0],
            ['code' => '1020102', 'name' => '存入採購單據', 'level' => 3, 'route_name' => 'purchaseOrder::@store', 'enabled' => 0],
            ['code' => '1020103', 'name' => '檢視採購單據', 'level' => 3, 'route_name' => 'purchaseOrder::@show', 'enabled' => 0],
            ['code' => '1020104', 'name' => '維護採購單據', 'level' => 3, 'route_name' => 'purchaseOrder::@edit', 'enabled' => 0],
            ['code' => '1020105', 'name' => '更新採購單據', 'level' => 3, 'route_name' => 'purchaseOrder::@update', 'enabled' => 0],
            ['code' => '1020106', 'name' => '刪除採購單據', 'level' => 3, 'route_name' => 'purchaseOrder::@destroy', 'enabled' => 0],

            ['code' => '10202'  , 'name' => '進貨單管理', 'level' => 2, 'route_name' => 'billOfPurchase::index', 'enabled' => 1],
            ['code' => '1020201', 'name' => '新增進貨單據', 'level' => 3, 'route_name' => 'billOfPurchase::create', 'enabled' => 1],
            ['code' => '1020202', 'name' => '存入進貨單據', 'level' => 3, 'route_name' => 'billOfPurchase::store', 'enabled' => 1],
            ['code' => '1020203', 'name' => '檢視進貨單據', 'level' => 3, 'route_name' => 'billOfPurchase::show', 'enabled' => 1],
            ['code' => '1020204', 'name' => '維護進貨單據', 'level' => 3, 'route_name' => 'billOfPurchase::edit', 'enabled' => 1],
            ['code' => '1020205', 'name' => '更新進貨單據', 'level' => 3, 'route_name' => 'billOfPurchase::update', 'enabled' => 1],
            ['code' => '1020206', 'name' => '刪除進貨單據', 'level' => 3, 'route_name' => 'billOfPurchase::destroy', 'enabled' => 1],

            ['code' => '10203'  , 'name' => '進貨退回單管理', 'level' => 2, 'route_name' => 'returnOfPurchase::index', 'enabled' => 1],
            ['code' => '1020301', 'name' => '新增進貨退回單據', 'level' => 3, 'route_name' => 'returnOfPurchase::create', 'enabled' => 1],
            ['code' => '1020302', 'name' => '存入進貨退回單據', 'level' => 3, 'route_name' => 'returnOfPurchase::store', 'enabled' => 1],
            ['code' => '1020303', 'name' => '檢視進貨退回單據', 'level' => 3, 'route_name' => 'returnOfPurchase::show', 'enabled' => 1],
            ['code' => '1020304', 'name' => '維護進貨退回單據', 'level' => 3, 'route_name' => 'returnOfPurchase::edit', 'enabled' => 1],
            ['code' => '1020305', 'name' => '更新進貨退回單據', 'level' => 3, 'route_name' => 'returnOfPurchase::update', 'enabled' => 1],
            ['code' => '1020306', 'name' => '刪除進貨退回單據', 'level' => 3, 'route_name' => 'returnOfPurchase::destroy', 'enabled' => 1],

            ['code' => '10204'  , 'name' => '付款單管理', 'level' => 2, 'route_name' => 'payment::index', 'enabled' => 1],
            ['code' => '1020401', 'name' => '新增付款單', 'level' => 3, 'route_name' => 'payment::create', 'enabled' => 1],
            ['code' => '1020402', 'name' => '存入付款單', 'level' => 3, 'route_name' => 'payment::store', 'enabled' => 1],
            ['code' => '1020403', 'name' => '檢視付款單', 'level' => 3, 'route_name' => 'payment::show', 'enabled' => 1],
            ['code' => '1020404', 'name' => '維護付款單', 'level' => 3, 'route_name' => 'payment::edit', 'enabled' => 1],
            ['code' => '1020405', 'name' => '更新付款單', 'level' => 3, 'route_name' => 'payment::update', 'enabled' => 1],
            ['code' => '1020406', 'name' => '刪除付款單', 'level' => 3, 'route_name' => 'payment::destroy', 'enabled' => 1],

            ['code' => '10205'  , 'name' => '應付帳款沖銷單管理', 'level' => 2, 'route_name' => 'payableWriteOff::index', 'enabled' => 1],
            ['code' => '1020501', 'name' => '新增應付帳款沖銷單', 'level' => 3, 'route_name' => 'payableWriteOff::create', 'enabled' => 1],
            ['code' => '1020502', 'name' => '存入應付帳款沖銷單', 'level' => 3, 'route_name' => 'payableWriteOff::store', 'enabled' => 1],
            ['code' => '1020503', 'name' => '檢視應付帳款沖銷單', 'level' => 3, 'route_name' => 'payableWriteOff::show', 'enabled' => 1],
            ['code' => '1020504', 'name' => '維護應付帳款沖銷單', 'level' => 3, 'route_name' => 'payableWriteOff::edit', 'enabled' => 1],
            ['code' => '1020505', 'name' => '更新應付帳款沖銷單', 'level' => 3, 'route_name' => 'payableWriteOff::update', 'enabled' => 1],
            ['code' => '1020506', 'name' => '刪除應付帳款沖銷單', 'level' => 3, 'route_name' => 'payableWriteOff::destroy', 'enabled' => 1],

            ['code' => '103'    , 'name' => '銷貨作業', 'level' => 1, 'route_name' => 'menu::sale', 'enabled' => 1],
            ['code' => '10301'  , 'name' => '訂購單管理', 'level' => 2, 'route_name' => 'saleOrderController@index', 'enabled' => 0],
            ['code' => '1030101', 'name' => '新增訂購單據', 'level' => 3, 'route_name' => 'saleOrderController@create', 'enabled' => 0],
            ['code' => '1030102', 'name' => '存入訂購單據', 'level' => 3, 'route_name' => 'saleOrderController@store', 'enabled' => 0],
            ['code' => '1030103', 'name' => '檢視訂購單據', 'level' => 3, 'route_name' => 'saleOrderController@show', 'enabled' => 0],
            ['code' => '1030104', 'name' => '維護訂購單據', 'level' => 3, 'route_name' => 'saleOrderController@edit', 'enabled' => 0],
            ['code' => '1030105', 'name' => '更新訂購單據', 'level' => 3, 'route_name' => 'saleOrderController@update', 'enabled' => 0],
            ['code' => '1030106', 'name' => '刪除訂購單據', 'level' => 3, 'route_name' => 'saleOrderController@destroy', 'enabled' => 0],

            ['code' => '10302'  , 'name' => '銷貨單管理', 'level' => 2, 'route_name' => 'billOfSale::index', 'enabled' => 1],
            ['code' => '1030201', 'name' => '新增銷貨單據', 'level' => 3, 'route_name' => 'billOfSale::create', 'enabled' => 1],
            ['code' => '1030202', 'name' => '存入銷貨單據', 'level' => 3, 'route_name' => 'billOfSale::store', 'enabled' => 1],
            ['code' => '1030203', 'name' => '檢視銷貨單據', 'level' => 3, 'route_name' => 'billOfSale::show', 'enabled' => 1],
            ['code' => '1030204', 'name' => '維護銷貨單據', 'level' => 3, 'route_name' => 'billOfSale::edit', 'enabled' => 1],
            ['code' => '1030205', 'name' => '更新銷貨單據', 'level' => 3, 'route_name' => 'billOfSale::update', 'enabled' => 1],
            ['code' => '1030206', 'name' => '刪除銷貨單據', 'level' => 3, 'route_name' => 'billOfSale::destroy', 'enabled' => 1],

            ['code' => '10303'  , 'name' => '銷貨退回單管理', 'level' => 2, 'route_name' => 'returnOfSale::index', 'enabled' => 1],
            ['code' => '1030301', 'name' => '新增銷貨退回單據', 'level' => 3, 'route_name' => 'returnOfSale::create', 'enabled' => 1],
            ['code' => '1030302', 'name' => '存入銷貨退回單據', 'level' => 3, 'route_name' => 'returnOfSale::store', 'enabled' => 1],
            ['code' => '1030303', 'name' => '檢視銷貨退回單據', 'level' => 3, 'route_name' => 'returnOfSale::show', 'enabled' => 1],
            ['code' => '1030304', 'name' => '維護銷貨退回單據', 'level' => 3, 'route_name' => 'returnOfSale::edit', 'enabled' => 1],
            ['code' => '1030305', 'name' => '更新銷貨退回單據', 'level' => 3, 'route_name' => 'returnOfSale::update', 'enabled' => 1],
            ['code' => '1030306', 'name' => '刪除銷貨退回單據', 'level' => 3, 'route_name' => 'returnOfSale::destroy', 'enabled' => 1],

            ['code' => '10304'  , 'name' => '銷貨日報表', 'level' => 2, 'route_name' => 'saleReport::index', 'enabled' => 1],

            ['code' => '10305'  , 'name' => '對帳單列印', 'level' => 2, 'route_name' => 'statement::index', 'enabled' => 1],

            ['code' => '10306'  , 'name' => '收款單管理', 'level' => 2, 'route_name' => 'receipt::index', 'enabled' => 1],
            ['code' => '1030601', 'name' => '新增收款單', 'level' => 3, 'route_name' => 'receipt::create', 'enabled' => 1],
            ['code' => '1030602', 'name' => '存入收款單', 'level' => 3, 'route_name' => 'receipt::store', 'enabled' => 1],
            ['code' => '1030603', 'name' => '檢視收款單', 'level' => 3, 'route_name' => 'receipt::show', 'enabled' => 1],
            ['code' => '1030604', 'name' => '維護收款單', 'level' => 3, 'route_name' => 'receipt::edit', 'enabled' => 1],
            ['code' => '1030605', 'name' => '更新收款單', 'level' => 3, 'route_name' => 'receipt::update', 'enabled' => 1],
            ['code' => '1030606', 'name' => '刪除收款單', 'level' => 3, 'route_name' => 'receipt::destroy', 'enabled' => 1],

            ['code' => '10307'  , 'name' => '應收帳款沖銷單管理', 'level' => 2, 'route_name' => 'receivableWriteOff::index', 'enabled' => 1],
            ['code' => '1030701', 'name' => '新增應收帳款沖銷單', 'level' => 3, 'route_name' => 'receivableWriteOff::create', 'enabled' => 1],
            ['code' => '1030702', 'name' => '存入應收帳款沖銷單', 'level' => 3, 'route_name' => 'receivableWriteOff::store', 'enabled' => 1],
            ['code' => '1030703', 'name' => '檢視應收帳款沖銷單', 'level' => 3, 'route_name' => 'receivableWriteOff::show', 'enabled' => 1],
            ['code' => '1030704', 'name' => '維護應收帳款沖銷單', 'level' => 3, 'route_name' => 'receivableWriteOff::edit', 'enabled' => 1],
            ['code' => '1030705', 'name' => '更新應收帳款沖銷單', 'level' => 3, 'route_name' => 'receivableWriteOff::update', 'enabled' => 1],
            ['code' => '1030706', 'name' => '刪除應收帳款沖銷單', 'level' => 3, 'route_name' => 'receivableWriteOff::destroy', 'enabled' => 1],

            ['code' => '104'    , 'name' => '存貨管理作業', 'level' => 1, 'route_name' => 'menu::stockManager', 'enabled' => 1],
            ['code' => '10401'  , 'name' => '調整單管理', 'level' => 2, 'route_name' => 'stockAdjust::index', 'enabled' => 1],
            ['code' => '1040101', 'name' => '新增調整單', 'level' => 3, 'route_name' => 'stockAdjust::create', 'enabled' => 1],
            ['code' => '1040102', 'name' => '存入調整單', 'level' => 3, 'route_name' => 'stockAdjust::store', 'enabled' => 1],
            ['code' => '1040103', 'name' => '檢視調整單', 'level' => 3, 'route_name' => 'stockAdjust::show', 'enabled' => 1],
            ['code' => '1040104', 'name' => '維護調整單', 'level' => 3, 'route_name' => 'stockAdjust::edit', 'enabled' => 1],
            ['code' => '1040105', 'name' => '更新調整單', 'level' => 3, 'route_name' => 'stockAdjust::update', 'enabled' => 1],
            ['code' => '1040106', 'name' => '刪除調整單', 'level' => 3, 'route_name' => 'stockAdjust::destroy', 'enabled' => 1],

            ['code' => '10402'  , 'name' => '轉倉單管理', 'level' => 2, 'route_name' => 'stockTransfer::index', 'enabled' => 1],
            ['code' => '1040201', 'name' => '新增轉倉單', 'level' => 3, 'route_name' => 'stockTransfer::create', 'enabled' => 1],
            ['code' => '1040202', 'name' => '存入轉倉單', 'level' => 3, 'route_name' => 'stockTransfer::store', 'enabled' => 1],
            ['code' => '1040203', 'name' => '檢視轉倉單', 'level' => 3, 'route_name' => 'stockTransfer::show', 'enabled' => 1],
            ['code' => '1040204', 'name' => '維護轉倉單', 'level' => 3, 'route_name' => 'stockTransfer::edit', 'enabled' => 1],
            ['code' => '1040205', 'name' => '更新轉倉單', 'level' => 3, 'route_name' => 'stockTransfer::update', 'enabled' => 1],
            ['code' => '1040206', 'name' => '刪除轉倉單', 'level' => 3, 'route_name' => 'stockTransfer::destroy', 'enabled' => 1],

            ['code' => '10403'  , 'name' => '庫存異動表', 'level' => 2, 'route_name' => 'stockInOutReport::index', 'enabled' => 1],
            ['code' => '1040301', 'name' => '庫存異動表-列出查詢結果', 'level' => 3, 'route_name' => 'stockInOutReport::show', 'enabled' => 1],
            ['code' => '10404'  , 'name' => '庫存總表', 'level' => 2, 'route_name' => 'report::index', 'enabled' => 1],
            ['code' => '1040401', 'name' => '庫存總表-列出查詢結果', 'level' => 3, 'route_name' => 'report::show', 'enabled' => 1],

            ['code' => '105'    , 'name' => '系統', 'level' => 1, 'route_name' => 'menu::system', 'enabled' => 1],
            ['code' => '10501'  , 'name' => '系統參數設定', 'level' => 2, 'route_name' => 'systemConfig::index', 'enabled' => 1],
            ['code' => '1050101', 'name' => '維護系統參數', 'level' => 3, 'route_name' => 'systemConfig::edit', 'enabled' => 1],
            ['code' => '1050102', 'name' => '更新系統參數', 'level' => 3, 'route_name' => 'systemConfig::update', 'enabled' => 1],

            ['code' => '10502'  , 'name' => '使用者資料管理', 'level' => 2, 'route_name' => 'CRUD::index', 'enabled' => 1],
            ['code' => '1050201', 'name' => '新增使用者資料', 'level' => 3, 'route_name' => 'CRUD::create', 'enabled' => 1],
            ['code' => '1050202', 'name' => '存入使用者資料', 'level' => 3, 'route_name' => 'CRUD::store', 'enabled' => 1],
            ['code' => '1050203', 'name' => '檢視使用者資料', 'level' => 3, 'route_name' => 'CRUD::show', 'enabled' => 1],
            ['code' => '1050204', 'name' => '維護使用者資料', 'level' => 3, 'route_name' => 'CRUD::edit', 'enabled' => 1],
            ['code' => '1050205', 'name' => '更新使用者資料', 'level' => 3, 'route_name' => 'CRUD::update', 'enabled' => 1],
            ['code' => '1050206', 'name' => '刪除使用者資料', 'level' => 3, 'route_name' => 'CRUD::destroy', 'enabled' => 1],

            ['code' => '10504', 'name' => '資料備份匯出', 'level' => 2, 'route_name' => 'systemConfig::exportSettings', 'enabled' => 1],
            ['code' => '10505', 'name' => '資料備份匯入', 'level' => 2, 'route_name' => 'systemConfig::importSettings', 'enabled' => 1],
            ['code' => '10506', 'name' => '系統更新記錄', 'level' => 2, 'route_name' => 'systemConfig::updateLogs', 'enabled' => 1],

            ['code' => '106'    , 'name' => '電商平台作業', 'level' => 1, 'route_name' => 'menu::B2C', 'enabled' => 1],
            ['code' => '10601'  , 'name' => '電商平台品名對照表', 'level' => 2, 'route_name' => 'itemMappingEditor::index', 'enabled' => 1],
            ['code' => '1060101', 'name' => '電商平台品名對照表編輯器', 'level' => 3, 'route_name' => 'itemMappingEditor::subIndex', 'enabled' => 1],
            ['code' => '10602'  , 'name' => '電商平台訂單EXCEL上傳', 'level' => 2, 'route_name' => 'orderUploader::index', 'enabled' => 1],
            ['code' => '10603'  , 'name' => '電商平台訂單管理', 'level' => 2, 'route_name' => 'B2COrder::index', 'enabled' => 1],
            ['code' => '1060301', 'name' => '電商平台訂單上傳紀錄', 'level' => 3, 'route_name' => 'B2COrder::subIndex', 'enabled' => 1],
            ['code' => '1060302', 'name' => '電商平台訂單內容', 'level' => 3, 'route_name' => 'B2COrder::detail', 'enabled' => 1],
        ];

        DB::table('erp_pages')->truncate();
        DB::table('erp_pages')->insert($pages);
    }
}
