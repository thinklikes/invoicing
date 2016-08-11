<?php

namespace Erp\Providers;

use Illuminate\Support\ServiceProvider;

class BarcodePrinterServiceProvider extends ServiceProvider
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
            'Erp\BarcodePrinter\BarcodePrinterInterface',
            //'Erp\BarcodePrinter\PrintBarcode'
            function ($app, $param = null) {
                if ($param['app_name'] == 'company') {
                    return $app->make('Erp\BarcodePrinter\PrintBarcode');
                } else {
                    return $app->make('Erp\BarcodePrinter\PrintNothing');
                }
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
