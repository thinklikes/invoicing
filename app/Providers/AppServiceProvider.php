<?php

namespace App\Providers;
use App\SystemConfig;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
use Recca0120\LaravelTracy\LaravelTracyServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Sharing Data With All Views
         */
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local')
        {
            $this->app->register(LaravelTracyServiceProvider::class);
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }
}
