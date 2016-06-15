<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        $requestMethod = '';
        $className = Config::get('className');
        switch ($className) {
            case 'BillOfPurchaseController':
                $requestMethod = 'BillOfPurchaseRequest';
                break;
            case 'ReturnOfPurchaseController':
                $requestMethod = 'ReturnOfPurchaseRequest';
                break;
        }
        if ($requestMethod != '')
        //將FormRequestInterface綁定BillOfPurchaseRequest
        $this->app->bind('App\Contracts\FormRequestInterface',
            'App\Http\Requests\\'.$requestMethod);
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
