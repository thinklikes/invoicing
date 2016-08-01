<?php

namespace App\Providers;

use Schema;
use App;
use Illuminate\Support\ServiceProvider;
use Option\OptionRepository;

class SystemConfigsServiceProvider extends ServiceProvider
{
    /**
     * 指定提供者載入是否延緩。
     *
     * @var bool
     */
    //protected $defer = true;

    public function boot()
    {
        /**
         * 把系統設定值放入Config
         *
         */
        //如果有這個資料表
        if (Schema::hasTable('erp_options'))
        {
            $configs = App::make(OptionRepository::class)->getAllConfigs();
            $output = [];
            foreach ($configs as $key => $value) {
                $output[$value['code']] = $value['value'];
            }
            config([
                'system_configs' => $output
            ]);
        }
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
