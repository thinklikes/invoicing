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

    $a = App::make('ReturnOfSale\ReturnOfSaleRepository');
    return $a->getNewOrderCode();
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
        Route::resource('/billOfPurchase', 'BillOfPurchaseController');
        //進貨退回作業
        Route::post('/returnOfPurchase/json/{data_mode}/{code}', 'ReturnOfPurchaseController@json');
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

        //進貨單作業
        Route::post('/billOfSale/json/{data_mode}/{code}', 'BillOfSaleController@json');
        Route::resource('/billOfSale', 'BillOfSaleController');
        //進貨退回作業
        Route::post('/returnOfSale/json/{data_mode}/{code}', 'ReturnOfSaleController@json');
        Route::resource('/returnOfSale', 'ReturnOfSaleController');

        Route::post('/receipt/json/{data_mode}/{code}', 'ReceiptController@json');
        Route::resource('/receipt', 'ReceiptController');

        //應付帳款沖銷單管理
        Route::resource('/receivableWriteOff', 'ReceivableWriteOffController',
            [
                'except' => ['edit', 'update']
            ]
        );
    });
});