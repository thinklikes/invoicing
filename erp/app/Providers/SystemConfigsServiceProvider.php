<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\OptionRepository;
use Config;

class SystemConfigsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * 把系統設定值放入Config
         *
         */
        $configs = OptionRepository::getAllConfigs();
        $output = [];
        foreach ($configs as $key => $value) {
            $output[$value['code']] = $value['value'];
        }
        Config::set([
            'system_configs' => $output
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
