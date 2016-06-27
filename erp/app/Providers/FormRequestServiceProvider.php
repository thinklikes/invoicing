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
            function ($app, $param) {
                $requestMethod = '';
                switch ($param['className']) {
                    case 'Purchase\BillOfPurchaseController':
                        $requestMethod = 'App\Http\Requests\Purchase\BillOfPurchaseRequest';
                        break;
                    case 'Purchase\ReturnOfPurchaseController':
                        $requestMethod = 'App\Http\Requests\Purchase\ReturnOfPurchaseRequest';
                        break;
                    case 'Purchase\PaymentOfPurchaseController':
                        $requestMethod = 'App\Http\Requests\Purchase\PaymentOfPurchaseRequest';
                        break;
                    default:
                        $requestMethod = 'App\Http\Requests\ErpRequest';
                        break;
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
