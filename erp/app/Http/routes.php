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
        return view('layouts.test');
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

    Route::get('/base', 'PageController@base');

    Route::get('/purchase', 'PageController@purchase');

    Route::get('/sale', 'PageController@sale');

    //系統設定維護
    Route::get('/system_configs', [
        'uses' => 'SystemConfigController@index',
        'as'   => 'system_configs.index',
    ]);
    Route::get('/system_configs/edit', [
        'uses' => 'SystemConfigController@edit',
        'as' => 'system_configs.edit'
    ]);
    Route::put('/system_configs/update', [
        'uses' => 'SystemConfigController@update',
        'as' => 'system_configs.update'
    ]);

    //客戶資料管理
    Route::resource('/customers', 'CustomerController');

    //供應商資料管理
    Route::post('/suppliers/json', 'SupplierController@json');
    Route::resource('/suppliers', 'SupplierController');

    //料品資料管理
    Route::post('/stocks/json', 'StockController@json');
    Route::resource('/stocks', 'StockController');

    //稅別資料管理
    Route::resource('/tax_rates', 'TaxRateController');

    //料品單位管理
    Route::resource('/units', 'UnitController');

    //倉庫資料管理
    Route::resource('/stock_classes', 'StockClassController');

    //付款方式管理
    Route::resource('/pay_ways', 'PayWayController');

    //倉庫資料管理
    Route::resource('/warehouses', 'WarehouseController');

    //採購單作業
    Route::resource('/purchase_orders', 'PurchaseOrderController');

    //進貨單作業
    Route::resource('/billsOfPurchase', 'BillOfPurchaseController');

    //銷貨作業
    Route::resource('/sales', 'SaleController');
});