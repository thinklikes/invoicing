<?php

namespace Erp\Providers;

use Illuminate\Support\ServiceProvider;

class CRUDServiceFactoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //BarcodePrinterInterface
        $this->app->bind(
            "Erp\\Services\\CRUDServiceInterface",
            //'Erp\BarcodePrinter\PrintBarcode'
            function ($app, $param = null) {
                $service = ucfirst($param['app_name']).'Service';
                //將介面綁定Service程式
                return $app->make("Erp\\Services\\".$service);
            }
        );
    }

    /**
     * 緩載提供者時, 取得提供者所提供的服務。
     *
     * @return array
     */
    // public function provides()
    // {
    //     return [
    //         //'Erp\BarcodePrinter\PrintBarcodeInterface'
    //     ];
    // }
}
