<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
DB::enableQueryLog();

Route::auth();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/test', 'AdminTestController@index');

    //首頁
    Route::get('/', 'PageController@portal');

    Route::get('/erp', 'PageController@index');

    Route::get('/basic', 'PageController@basic');

    Route::get('/purchase', 'PageController@purchase');

    Route::get('/sale', 'PageController@sale');

    Route::get('/stockManager', 'PageController@stockManager');
    //採購單作業
    Route::resource('/purchase_orders', 'PurchaseOrderController');

    Route::group(['namespace' => 'Basic'], function() {
        //系統設定維護
        Route::get('/system_config', 'SystemConfigController@index');
        Route::get('/system_config/edit', 'SystemConfigController@edit');
        Route::put('/system_config/update', 'SystemConfigController@update');

        //客戶資料管理
        //Route::resource('/customer', 'CustomerController');
        Route::post('/company/json', 'CompanyController@json');
        //供應商資料管理
        Route::post('/supplier/json', 'SupplierController@json');
        Route::resource('/supplier', 'SupplierController');

        //料品資料管理
        Route::post('/stock/json', 'StockController@json');
        Route::resource('/stock', 'StockController');

        //料品單位管理
        Route::resource('/unit', 'UnitController');

        //倉庫資料管理
        Route::resource('/stock_class', 'StockClassController');

        //付款方式管理
        Route::resource('/pay_way', 'PayWayController');

        //倉庫資料管理
        Route::resource('/warehouse', 'WarehouseController');

    });
    Route::group(['namespace' => 'Purchase'], function() {

        //進貨單作業
        Route::post('/billOfPurchase/json/{data_mode}/{code}', 'BillOfPurchaseController@json');
        Route::get('/billOfPurchase/{code}/printing', 'BillOfPurchaseController@printing');
        Route::resource('/billOfPurchase', 'BillOfPurchaseController');
        //進貨退回作業
        Route::post('/returnOfPurchase/json/{data_mode}/{code}', 'ReturnOfPurchaseController@json');
        Route::get('/returnOfPurchase/{code}/printing', 'ReturnOfPurchaseController@printing');
        Route::resource('/returnOfPurchase', 'ReturnOfPurchaseController');

        Route::post('/payment/json/{data_mode}/{code}', 'PaymentController@json');
        Route::resource('/payment', 'PaymentController');

        //應付帳款沖銷單管理
        Route::resource('/payableWriteOff', 'PayableWriteOffController',
            [
                'except' => ['edit', 'update']
            ]
        );
    });

    //銷貨作業
    Route::group(['namespace' => 'Sale'], function() {

        //銷貨單作業
        Route::post('/billOfSale/json/{data_mode}/{code}', 'BillOfSaleController@json');
        Route::get('/billOfSale/{code}/printing', 'BillOfSaleController@printing');
        Route::resource('/billOfSale', 'BillOfSaleController');
        //銷貨退回作業
        Route::post('/returnOfSale/json/{data_mode}/{code}', 'ReturnOfSaleController@json');
        Route::get('/returnOfSale/{code}/printing', 'ReturnOfSaleController@printing');
        Route::resource('/returnOfSale', 'ReturnOfSaleController');

        Route::post('/receipt/json/{data_mode}/{code}', 'ReceiptController@json');
        Route::resource('/receipt', 'ReceiptController');

        //應收帳款沖銷單管理
        Route::resource('/receivableWriteOff', 'ReceivableWriteOffController',
            [
                'except' => ['edit', 'update']
            ]
        );
    });

    //存貨管理作業
    Route::group(['namespace' => 'StockManager'], function() {

        //調整單作業
        Route::get('/stockAdjust/{code}/printing', 'StockAdjustController@printing');
        Route::resource('/stockAdjust', 'StockAdjustController');
        //轉倉單作業
        Route::get('/stockTransfer/{code}/printing', 'StockTransferController@printing');
        Route::resource('/stockTransfer', 'StockTransferController');
        //庫存異動報表
        Route::get('/stockInOutReport', 'StockInOutReportController@index');
        Route::get('/stockInOutReport/printing', 'StockInOutReportController@printing');
    });
});