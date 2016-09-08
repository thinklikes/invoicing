<?php

namespace Erp\Providers;

use Illuminate\Support\ServiceProvider;

class ReportServiceFactoryProvider extends ServiceProvider
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
        $this->app->bind(
            "Erp\\Services\\ReportServiceInterface",
            //'Erp\BarcodePrinter\PrintBarcode'
            function ($app, $param = null) {
                $service = ucfirst($param['app_name']).'Service';
                //將介面綁定Service程式
                return $app->make("Erp\\Services\\".$service);
            }
        );
    }
}
