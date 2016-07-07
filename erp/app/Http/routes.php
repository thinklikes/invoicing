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

Route::get('/test', function () {
    // $faker = new Faker\Generator;
    // $faker->addProvider(new Faker\Provider\zh_TW\Person($faker));
    // $faker->addProvider(new Faker\Provider\zh_TW\Address($faker));
    // $faker->addProvider(new Faker\Provider\zh_TW\PhoneNumber($faker));
    // $faker->addProvider(new Faker\Provider\zh_TW\Company($faker));
    // for ($i = 0; $i < 100; $i++) {
    //     echo '<sapn style="font-family:Fixedsys, Meiryo;">'.$faker->unique()->regexify('[A-Za-z0-9]{5}')."</span><br>";
    // }
    //return view('layouts.test');

    //$collection = collect([['name' => 'Desk', 'price' => 100], ['name' => 'Table', 'price' => 200]]);

    // $collection->contains('Desk');

    $a = App::make('App\Repositories\Purchase\ReturnOfPurchaseRepository');
    return $a->getNotPaidAmount('20160707001');
});

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
        Route::post('/billsOfPurchase/json/{data_mode}/{code}', 'BillOfPurchaseController@json');
        Route::resource('/billsOfPurchase', 'BillOfPurchaseController');
        //進貨退回作業
        Route::post('/returnsOfPurchase/json/{data_mode}/{code}', 'ReturnOfPurchaseController@json');
        Route::resource('/returnsOfPurchase', 'ReturnOfPurchaseController');

        Route::post('/payments/json/{data_mode}/{code}', 'PaymentController@json');
        Route::resource('/payments', 'PaymentController');

        Route::get('/payableWriteOff/beforeCreate', 'PayableWriteOffController@beforeCreate');
        Route::resource('/payableWriteOff', 'PayableWriteOffController');
    });
    //進貨退回單作業

    //銷貨作業
    Route::resource('/sales', 'SaleController');
});