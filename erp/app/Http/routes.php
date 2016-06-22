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
        /**
         * Arrange
         * 產生表身假資料，表身的code是另外存入
         */
        $target = App::make(App\Repositories\Purchase\BillOfPurchaseRepository::class);
        $code = date('Ymd').sprintf('%03d', '999');
        $num = 2;
        $data = factory(App\Purchase\BillOfPurchaseDetail::class, $num)->make();
        /**
         * Assert
         * 測試是否成功
         */
        for($i=0; $i < $num; $i++) {

            /**
             * Act
             * 存入表身
             */
            $actual_1 = $target->storeOrderDetail($data[$i], $code);
            $actual_2 = App\Purchase\BillOfPurchaseDetail::where('master_code', $code)->skip($i)->take(1)->firstOrFail();
                var_dump($actual_2);
            // $this->assertTrue($actual_1);
            // //測試存入的欄位是否跟取出的欄位值一樣
            // $this->assertEquals($data[$i]->stock_id, $actual_2->stock_id);
            // $this->assertEquals($data[$i]->quantity, $actual_2->quantity);
            // $this->assertEquals($data[$i]->no_tax_price, $actual_2->no_tax_price);
        }
        //return ($a) ? 123 : 456;
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