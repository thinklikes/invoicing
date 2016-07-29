<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use Config;

class FormRequestServiceProvider extends ServiceProvider
{
    /**
     * 指定提供者載入是否延緩。
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //將FormRequestInterface綁定Request
        $this->app->bind(
            'App\Contracts\FormRequestInterface',
            function ($app, $param = null) {
                $requestMethod = '';
                if (!empty($param)) {
                    switch ($param['className']) {
                        case 'Purchase\BillOfPurchaseController':
                            $requestMethod = 'BillOfPurchase\BillOfPurchaseRequest';
                            break;
                        case 'Purchase\ReturnOfPurchaseController':
                            $requestMethod = 'ReturnOfPurchase\ReturnOfPurchaseRequest';
                            break;
                        case 'Purchase\PaymentController':
                            $requestMethod = 'Payment\PaymentRequest';
                            break;
                        case 'Purchase\PayableWriteOffController':
                            $requestMethod = 'PayableWriteOff\PayableWriteOffRequest';
                            break;
                        case 'Sale\BillOfSaleController':
                            $requestMethod = 'BillOfSale\BillOfSaleRequest';
                            break;
                        case 'Sale\ReturnOfSaleController':
                            $requestMethod = 'ReturnOfSale\ReturnOfSaleRequest';
                            break;
                        case 'Sale\ReceiptController':
                            $requestMethod = 'Receipt\ReceiptRequest';
                            break;
                        case 'Sale\ReceivableWriteOffController':
                            $requestMethod = 'ReceivableWriteOff\ReceivableWriteOffRequest';
                            break;
                        case 'StockManager\StockAdjustController':
                            $requestMethod = 'StockAdjust\StockAdjustRequest';
                            break;
                        case 'StockManager\StockTransferController':
                            $requestMethod = 'StockTransfer\StockTransferRequest';
                            break;
                    }
                } else {
                    $requestMethod = 'App\Http\Requests\ErpRequest';
                }
                return App::make($requestMethod);
            }
        );
    }

    /**
     * 取得提供者所提供的服務。
     *
     * @return array
     */
    public function provides()
    {
        return [
            'App\Contracts\FormRequestInterface'
        ];
    }
}
