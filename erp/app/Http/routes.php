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

    Route::get('/test', function () {
        $page = new App\Http\Requests\BillOfPurchaseRequest;
        //$page = new App\Http\Controllers\Purchase\BillOfPurchaseController;
        return $page->rules();
    });

    Route::get('/providers_test', function () {
        var_dump("from route");
        //App::register('App\Providers\FormRequestServiceProvider');
        $re = App::make('App\Http\Requests\FormRequestInterface');
        //dd($supplier->getSupplierDetail(1));
    });
    // Route::get('/providers_test', function (SupplierRepository $supplier) {
    //     var_dump("from route");
    //     //$supplier = App::make('SupplierRepository');
    //     dd($supplier->getSupplierDetail(1));
    // });

Route::auth();

Route::group(['middleware' => 'auth'], function () {

    //首頁
    Route::get('/', 'PageController@portal');

    Route::get('/erp', 'PageController@index');

    Route::get('/basic', 'PageController@basic');

    Route::get('/purchase', 'PageController@purchase');

    Route::get('/sale', 'PageController@sale');

    //採購單作業
    Route::resource('/purchase_orders', 'PurchaseOrderController');

    Route::group(['namespace' => 'Basic'], function() {
        //系統設定維護
        Route::get('/system_configs', 'SystemConfigController@index');
        Route::get('/system_configs/edit', 'SystemConfigController@edit');
        Route::put('/system_configs/update', 'SystemConfigController@update');

        //客戶資料管理
        Route::resource('/customers', 'CustomerController');

        //供應商資料管理
        Route::post('/suppliers/json', 'SupplierController@json');
        Route::resource('/suppliers', 'SupplierController');

        //料品資料管理
        Route::post('/stocks/json', 'StockController@json');
        Route::resource('/stocks', 'StockController');

        //料品單位管理
        Route::resource('/units', 'UnitController');

        //倉庫資料管理
        Route::resource('/stock_classes', 'StockClassController');

        //付款方式管理
        Route::resource('/pay_ways', 'PayWayController');

        //倉庫資料管理
        Route::resource('/warehouses', 'WarehouseController');

    });
    Route::group(['namespace' => 'Purchase'], function() {

        //進貨單作業
        Route::resource('/billsOfPurchase', 'BillOfPurchaseController');

    });
    //進貨退回單作業
    Route::resource('/returnsOfPurchase', 'ReturnOfPurchaseController');

    //銷貨作業
    Route::resource('/sales', 'SaleController');
});