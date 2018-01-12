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
                        case 'BillOfPurchaseController':
                            $requestMethod = 'BillOfPurchase\BillOfPurchaseRequest';
                            break;
                        case 'ReturnOfPurchaseController':
                            $requestMethod = 'ReturnOfPurchase\ReturnOfPurchaseRequest';
                            break;
                        case 'PaymentController':
                            $requestMethod = 'Payment\PaymentRequest';
                            break;
                        case 'PayableWriteOffController':
                            $requestMethod = 'PayableWriteOff\PayableWriteOffRequest';
                            break;
                        case 'BillOfSaleController':
                            $requestMethod = 'BillOfSale\BillOfSaleRequest';
                            break;
                        case 'ReturnOfSaleController':
                            $requestMethod = 'ReturnOfSale\ReturnOfSaleRequest';
                            break;
                        case 'ReceiptController':
                            $requestMethod = 'Receipt\ReceiptRequest';
                            break;
                        case 'ReceivableWriteOffController':
                            $requestMethod = 'ReceivableWriteOff\ReceivableWriteOffRequest';
                            break;
                        case 'StockAdjustController':
                            $requestMethod = 'StockAdjust\StockAdjustRequest';
                            break;
                        case 'StockTransferController':
                            $requestMethod = 'StockTransfer\StockTransferRequest';
                            break;
                        case 'user':
                            $requestMethod = 'Erp\Requests\UserRequest';
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
     * 緩載提供者時, 取得提供者所提供的服務。
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
