<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\StockWarehouseRepository;

class BillOfPurchaseServiceProvider extends ServiceProvider
{
    /**
     * 指定提供者載入是否延緩。
     *
     * @var bool
     */
    //protected $defer = true;

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
        $this->app->bind('StockWarehouseRepository', 'StockWarehouseRepository');
    }

    /**
     * 取得提供者所提供的服務。
     *
     * @return array
     */
    // public function provides()
    // {
    //     return [StockWarehouseRepository::class];
    // }
}
