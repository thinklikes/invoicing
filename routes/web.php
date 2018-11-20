<?php

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => 'auth'], function () {
    //首頁
    Route::get('/', 'PageController@portal')->name('portal');
    Route::group(['as' => 'menu-'], function () {
        Route::get('/menu/erp', 'PageController@menu')->name('erp');
        Route::get('/menu/basic', 'PageController@menu')->name('basic');
        Route::get('/menu/purchase', 'PageController@menu')->name('purchase');
        Route::get('/menu/sale', 'PageController@menu')->name('sale');
        Route::get('/menu/stockManager', 'PageController@menu')->name('stockManager');
        Route::get('/menu/system', 'PageController@menu')->name('system');
        Route::get('/menu/B2C', 'PageController@menu')->name('B2C');
    });

    //採購單作業
    Route::resource('/purchase_orders', 'PurchaseOrderController');
    //客戶訂單作業
    Route::resource('/sale_orders', 'SaleOrderController');

    //客戶資料管理
    Route::group(['as' => 'company-'], function () {
        Route::get('/company/{id}/printTag', 'CompanyController@printTag')->name('printTag');
        Route::get('/company/printTag', 'CompanyController@printTag')->name('printTagAll');
        Route::get('/company/{id}/printBarcode', 'CompanyController@printBarcode')->name('printBarcode');
        Route::get('/company/printBarcode', 'CompanyController@printBarcode')->name('printBarcodeAll');
        Route::post('/company/json', 'CompanyController@json')->name('json');
        Route::get('/company', 'CompanyController@index')->name('index');
        Route::get('/company/create', 'CompanyController@create')->name('create');
        Route::post('/company', 'CompanyController@store')->name('store');
        Route::get('/company/{id?}', 'CompanyController@show')->name('show');
        Route::get('/company/{id?}/edit', 'CompanyController@edit')->name('edit');
        Route::put('/company/{id?}', 'CompanyController@update')->name('update');
        Route::delete('/company/{id?}', 'CompanyController@destroy')->name('destroy');
    });
    //供應商資料管理
    Route::group(['as' => 'supplier-'], function () {
        Route::get('/supplier/{id}/printBarcode', 'SupplierController@printBarcode')->name('printBarcode');
        Route::get('/supplier/printBarcode', 'SupplierController@printBarcode')->name('printBarcode');
        Route::post('/supplier/json', 'SupplierController@json')->name('json');
        Route::get('/supplier', 'SupplierController@index')->name('index');
        Route::get('/supplier/create', 'SupplierController@create')->name('create');
        Route::post('/supplier', 'SupplierController@store')->name('store');
        Route::get('/supplier/{id?}', 'SupplierController@show')->name('show');
        Route::get('/supplier/{id?}/edit', 'SupplierController@edit')->name('edit');
        Route::put('/supplier/{id?}', 'SupplierController@update')->name('update');
        Route::delete('/supplier/{id?}', 'SupplierController@destroy')->name('destroy');
    });
    //料品資料管理
    Route::group(['as' => 'stock-'], function () {
        Route::get('/stock/{id}/printBarcode', 'StockController@printBarcode')->name('printBarcode');
        Route::get('/stock/printBarcode', 'StockController@printBarcode')->name('printBarcode');
        Route::post('/stock/json', 'StockController@json')->name('json');
        Route::get('/stock', 'StockController@index')->name('index');
        Route::get('/stock/create', 'StockController@create')->name('create');
        Route::post('/stock', 'StockController@store')->name('store');
        Route::get('/stock/{id?}', 'StockController@show')->name('show');
        Route::get('/stock/{id?}/edit', 'StockController@edit')->name('edit');
        Route::put('/stock/{id?}', 'StockController@update')->name('update');
        Route::delete('/stock/{id?}', 'StockController@destroy')->name('destroy');
    });
    //料品單位管理
    Route::group(['as' => 'unit-'], function () {
        Route::get('/unit', 'UnitController@index')->name('index');
        Route::get('/unit/create', 'UnitController@create')->name('create');
        Route::post('/unit', 'UnitController@store')->name('store');
        Route::get('/unit/{id?}', 'UnitController@show')->name('show');
        Route::get('/unit/{id?}/edit', 'UnitController@edit')->name('edit');
        Route::put('/unit/{id?}', 'UnitController@update')->name('update');
        Route::delete('/unit/{id?}', 'UnitController@destroy')->name('destroy');
    });

    //料品類別管理
    Route::group(['as' => 'stockClass-'], function () {
        Route::get('/stock_class', 'StockClassController@index')->name('index');
        Route::get('/stock_class/create', 'StockClassController@create')->name('create');
        Route::post('/stock_class', 'StockClassController@store')->name('store');
        Route::get('/stock_class/{id?}', 'StockClassController@show')->name('show');
        Route::get('/stock_class/{id?}/edit', 'StockClassController@edit')->name('edit');
        Route::put('/stock_class/{id?}', 'StockClassController@update')->name('update');
        Route::delete('/stock_class/{id?}', 'StockClassController@destroy')->name('destroy');
    });
    //付款方式管理
    Route::group(['as' => 'payWay-'], function () {
        Route::get('/pay_way', 'PayWayController@index')->name('index');
        Route::get('/pay_way/create', 'PayWayController@create')->name('create');
        Route::post('/pay_way', 'PayWayController@store')->name('store');
        Route::get('/pay_way/{id?}', 'PayWayController@show')->name('show');
        Route::get('/pay_way/{id?}/edit', 'PayWayController@edit')->name('edit');
        Route::put('/pay_way/{id?}', 'PayWayController@update')->name('update');
        Route::delete('/pay_way/{id?}', 'PayWayController@destroy')->name('destroy');
    });
    //倉庫資料管理
    Route::group(['as' => 'warehouse-'], function () {
        Route::get('/warehouse', 'WarehouseController@index')->name('index');
        Route::get('/warehouse/create', 'WarehouseController@create')->name('create');
        Route::post('/warehouse', 'WarehouseController@store')->name('store');
        Route::get('/warehouse/{id?}', 'WarehouseController@show')->name('show');
        Route::get('/warehouse/{id?}/edit', 'WarehouseController@edit')->name('edit');
        Route::put('/warehouse/{id?}', 'WarehouseController@update')->name('update');
        Route::delete('/warehouse/{id?}', 'WarehouseController@destroy')->name('destroy');
    });

    //系統設定維護
    Route::group(['as' => 'systemConfig-'], function () {
        Route::get('/system_config', 'SystemConfigController@index')->name('index');
        Route::get('/system_config/edit', 'SystemConfigController@edit')->name('edit');
        Route::put('/system_config/update', 'SystemConfigController@update')->name('update');
        //使用者權限管理
        // Route::get('/system_config/auth', 'SystemConfigController@auth')->name('auth');
        // Route::post('/system_config/auth', 'SystemConfigController@updateAuth')->name('updateAuth');
        //系統更新記錄
        Route::get('/system_config/updateLogs/{page?}', 'SystemConfigController@updateLogs')->name('updateLogs');
        //資料備份匯出
        Route::get('/system_config/export', 'SystemConfigController@exportSettings')->name('exportSettings');
        Route::post('/system_config/export', 'SystemConfigController@export');
        //資料備份匯入
        Route::get('/system_config/import', 'SystemConfigController@importSettings')->name('importSettings');
        Route::post('/system_config/import', 'SystemConfigController@import');
    });

    //進貨單作業
    Route::group(['as' => 'billOfPurchase-'], function () {
        Route::post('/billOfPurchase/json', 'BillOfPurchaseController@json')->name('json');
        Route::get('/billOfPurchase/{code}/printing', 'BillOfPurchaseController@printing')->name('printing');
        Route::get('/billOfPurchase/{code}/excel', 'BillOfPurchaseController@printing')->name('excel');
        Route::get('/billOfPurchase', 'BillOfPurchaseController@index')->name('index');
        Route::get('/billOfPurchase/create', 'BillOfPurchaseController@create')->name('create');
        Route::post('/billOfPurchase', 'BillOfPurchaseController@store')->name('store');
        Route::get('/billOfPurchase/{id?}', 'BillOfPurchaseController@show')->name('show');
        Route::get('/billOfPurchase/{id?}/edit', 'BillOfPurchaseController@edit')->name('edit');
        Route::put('/billOfPurchase/{id?}', 'BillOfPurchaseController@update')->name('update');
        Route::delete('/billOfPurchase/{id?}', 'BillOfPurchaseController@destroy')->name('destroy');
    });
    //進貨退回作業
    Route::group(['as' => 'returnOfPurchase-'], function () {
        Route::post('/returnOfPurchase/json/', 'ReturnOfPurchaseController@json')->name('json');
        Route::get('/returnOfPurchase/{code}/printing', 'ReturnOfPurchaseController@printing')->name('printing');
        Route::get('/returnOfPurchase/{code}/excel', 'ReturnOfPurchaseController@printing')->name('excel');
        Route::get('/returnOfPurchase', 'ReturnOfPurchaseController@index')->name('index');
        Route::get('/returnOfPurchase/create', 'ReturnOfPurchaseController@create')->name('create');
        Route::post('/returnOfPurchase', 'ReturnOfPurchaseController@store')->name('store');
        Route::get('/returnOfPurchase/{id?}', 'ReturnOfPurchaseController@show')->name('show');
        Route::get('/returnOfPurchase/{id?}/edit', 'ReturnOfPurchaseController@edit')->name('edit');
        Route::put('/returnOfPurchase/{id?}', 'ReturnOfPurchaseController@update')->name('update');
        Route::delete('/returnOfPurchase/{id?}', 'ReturnOfPurchaseController@destroy')->name('destroy');
    });

    Route::group(['as' => 'payment-'], function () {
        Route::post('/payment/json', 'PaymentController@json')->name('json');
        Route::get('/payment', 'PaymentController@index')->name('index');
        Route::get('/payment/create', 'PaymentController@create')->name('create');
        Route::post('/payment', 'PaymentController@store')->name('store');
        Route::get('/payment/{id?}', 'PaymentController@show')->name('show');
        Route::get('/payment/{id?}/edit', 'PaymentController@edit')->name('edit');
        Route::put('/payment/{id?}', 'PaymentController@update')->name('update');
        Route::delete('/payment/{id?}', 'PaymentController@destroy')->name('destroy');
    });
    //應付帳款沖銷單管理
    Route::group(['as' => 'payableWriteOff-'], function () {
        Route::get('/payableWriteOff', 'PayableWriteOffController@index')->name('index');
        Route::get('/payableWriteOff/create', 'PayableWriteOffController@create')->name('create');
        Route::post('/payableWriteOff', 'PayableWriteOffController@store')->name('store');
        Route::get('/payableWriteOff/{id?}', 'PayableWriteOffController@show')->name('show');
        Route::get('/payableWriteOff/{id?}/edit', 'PayableWriteOffController@edit')->name('edit');
        Route::put('/payableWriteOff/{id?}', 'PayableWriteOffController@update')->name('update');
        Route::delete('/payableWriteOff/{id?}', 'PayableWriteOffController@destroy')->name('destroy');
    });

    //銷貨單作業
    Route::group(['as' => 'billOfSale-'], function () {
        Route::post('/billOfSale/json', 'BillOfSaleController@json')->name('json');
        Route::get('/billOfSale/{code}/printing', 'BillOfSaleController@printing')->name('printing');
        Route::get('/billOfSale/{code}/excel', 'BillOfSaleController@printing')->name('excel');
        Route::get('/billOfSale', 'BillOfSaleController@index')->name('index');
        Route::get('/billOfSale/create', 'BillOfSaleController@create')->name('create');
        Route::post('/billOfSale', 'BillOfSaleController@store')->name('store');
        Route::get('/billOfSale/{id?}', 'BillOfSaleController@show')->name('show');
        Route::get('/billOfSale/{id?}/edit', 'BillOfSaleController@edit')->name('edit');
        Route::put('/billOfSale/{id?}', 'BillOfSaleController@update')->name('update');
        Route::delete('/billOfSale/{id?}', 'BillOfSaleController@destroy')->name('destroy');
    });
    //銷貨退回作業
    Route::group(['as' => 'returnOfSale-'], function () {
        Route::post('/returnOfSale/json', 'ReturnOfSaleController@json')->name('json');
        Route::get('/returnOfSale/{code}/printing', 'ReturnOfSaleController@printing')->name('printing');
        Route::get('/returnOfSale/{code}/excel', 'ReturnOfSaleController@printing')->name('excel');
        Route::get('/returnOfSale', 'ReturnOfSaleController@index')->name('index');
        Route::get('/returnOfSale/create', 'ReturnOfSaleController@create')->name('create');
        Route::post('/returnOfSale', 'ReturnOfSaleController@store')->name('store');
        Route::get('/returnOfSale/{id?}', 'ReturnOfSaleController@show')->name('show');
        Route::get('/returnOfSale/{id?}/edit', 'ReturnOfSaleController@edit')->name('edit');
        Route::put('/returnOfSale/{id?}', 'ReturnOfSaleController@update')->name('update');
        Route::delete('/returnOfSale/{id?}', 'ReturnOfSaleController@destroy')->name('destroy');
    });

    Route::group(['as' => 'receipt-'], function () {
        Route::post('/receipt/json', 'ReceiptController@json');
        Route::get('/receipt', 'ReceiptController@index')->name('index');
        Route::get('/receipt/create', 'ReceiptController@create')->name('create');
        Route::post('/receipt', 'ReceiptController@store')->name('store');
        Route::get('/receipt/{id?}', 'ReceiptController@show')->name('show');
        Route::get('/receipt/{id?}/edit', 'ReceiptController@edit')->name('edit');
        Route::put('/receipt/{id?}', 'ReceiptController@update')->name('update');
        Route::delete('/receipt/{id?}', 'ReceiptController@destroy')->name('destroy');
    });
    //應收帳款沖銷單管理
    Route::group(['as' => 'receivableWriteOff-'], function () {
        Route::get('/receivableWriteOff', 'ReceivableWriteOffController@index')->name('index');
        Route::get('/receivableWriteOff/create', 'ReceivableWriteOffController@create')->name('create');
        Route::post('/receivableWriteOff', 'ReceivableWriteOffController@store')->name('store');
        Route::get('/receivableWriteOff/{id?}', 'ReceivableWriteOffController@show')->name('show');
        Route::get('/receivableWriteOff/{id?}/edit', 'ReceivableWriteOffController@edit')->name('edit');
        Route::put('/receivableWriteOff/{id?}', 'ReceivableWriteOffController@update')->name('update');
        Route::delete('/receivableWriteOff/{id?}', 'ReceivableWriteOffController@destroy')->name('destroy');
    });
    //對帳單
    Route::group(['as' => 'statement-'], function () {
        Route::get('/statement/excel', 'StatementController@printing')->name('excel');
        Route::get('/statement', 'StatementController@index')->name('index');
        Route::get('/statement/printing', 'StatementController@printing')->name('printing');
    });

    //銷貨日報表
    Route::group(['as' => 'saleReport-'], function () {
        Route::get('/saleReport/excel', 'SaleReportController@printing')->name('excel');
        Route::get('/saleReport', 'SaleReportController@index')->name('index');
        Route::get('/saleReport/printing', 'SaleReportController@printing')->name('printing');
    });

    //調整單作業
    Route::group(['as' => 'stockAdjust-'], function () {
        Route::get('/stockAdjust/{code}/printing', 'StockAdjustController@printing');
        Route::get('/stockAdjust', 'StockAdjustController@index')->name('index');
        Route::get('/stockAdjust/create', 'StockAdjustController@create')->name('create');
        Route::post('/stockAdjust', 'StockAdjustController@store')->name('store');
        Route::get('/stockAdjust/{id?}', 'StockAdjustController@show')->name('show');
        Route::get('/stockAdjust/{id?}/edit', 'StockAdjustController@edit')->name('edit');
        Route::put('/stockAdjust/{id?}', 'StockAdjustController@update')->name('update');
        Route::delete('/stockAdjust/{id?}', 'StockAdjustController@destroy')->name('destroy');
    });
    //轉倉單作業
    Route::group(['as' => 'stockTransfer-'], function () {
        Route::get('/stockTransfer/{code}/printing', 'StockTransferController@printing')->name('printing');
        Route::get('/stockTransfer', 'StockTransferController@index')->name('index');
        Route::get('/stockTransfer/create', 'StockTransferController@create')->name('create');
        Route::post('/stockTransfer', 'StockTransferController@store')->name('store');
        Route::get('/stockTransfer/{id?}', 'StockTransferController@show')->name('show');
        Route::get('/stockTransfer/{id?}/edit', 'StockTransferController@edit')->name('edit');
        Route::put('/stockTransfer/{id?}', 'StockTransferController@update')->name('update');
        Route::delete('/stockTransfer/{id?}', 'StockTransferController@destroy')->name('destroy');
    });
    //庫存異動報表
    Route::group(['as' => 'stockInOutReport-'], function () {
        Route::get('/stockInOutReport/excel', 'StockInOutReportController@printing')->name('excel');
        Route::get('/stockInOutReport', 'StockInOutReportController@index')->name('index');
        Route::get('/stockInOutReport/printing', 'StockInOutReportController@printing')->name('printing');
    });

    //使用者與權限管理
    Route::group(['as' => 'CRUD-'], function () {
        Route::get('/user', 'CRUDController@index')->name('index');
        Route::get('/user/create', 'CRUDController@create')->name('create');
        Route::post('/user', 'CRUDController@store')->name('store');
        Route::get('/user/{id?}', 'CRUDController@show')->name('show');
        Route::get('/user/{id?}/edit', 'CRUDController@edit')->name('edit');
        Route::put('/user/{id?}', 'CRUDController@update')->name('update');
        Route::delete('/user/{id?}', 'CRUDController@destroy')->name('destroy');
    });
    //庫存總表
    Route::group(['as' => 'report-'], function () {
        Route::get('/stockAmountReport', 'ReportController@index')->name('index');
        Route::get('/stockAmountReport/printing', 'ReportController@printing')->name('printing');
    });

    //庫存總表
    Route::get('/orderUploader', 'OrderUploader@index')->name('orderUploader::index');
    Route::post('/orderUploader/save', 'OrderUploader@save')->name('orderUploader::save');

    // 電商平台品名對照表編輯器
    Route::group(['as' => 'itemMappingEditor-'], function() {
        Route::get('/itemMappingEditor', 'ItemMappingEditor@index')->name('index');
        Route::get('/itemMappingEditor/{platform}', 'ItemMappingEditor@subIndex')->name('subIndex');
        Route::post('/itemMappingEditor', 'ItemMappingEditor@save')->name('save');
    });

    Route::group(['as' => 'B2COrder-'], function() {
        Route::get('/b2cOrder', 'B2COrderController@index')->name('index');
        Route::get('/b2cOrder/{platform}', 'B2COrderController@subIndex')->name('subIndex');
        Route::get('/b2cOrder/detail/{platform}', 'B2COrderController@detail')->name('detail');
        Route::put('/b2cOrder/{platform}/{id}', 'B2COrderController@update')->name('update');
        Route::delete('/b2cOrder/deleteOrders/{platform}', 'B2COrderController@deleteOrders')->name('deleteOrders');
        Route::delete('/b2cOrder/{platform}/{id}', 'B2COrderController@delete')->name('delete');
        Route::get('/b2cOrder/export/{platform}', 'B2COrderController@export')->name('export');
        Route::get('/b2cOrder/exportBlackCat/{platform}', 'B2COrderController@exportBlackCat')->name('exportBlackCat');
        Route::get('/b2cOrder/exportSuperMarket/{platform}', 'B2COrderController@exportSuperMarket')->name('exportSuperMarket');
    });

    // Route::get('/test', function () {
    //     $path = storage_path('app/public');
    //     $filename = 'QDM.csv';

    //     $logic = App::make('App\Services\ExcelDataReaderForQDM');
    //     //$data = $logic->loadAndFetchData($path.'/'.$filename);

    // });
});