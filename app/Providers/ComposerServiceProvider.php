<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Option\OptionRepository;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * 在容器內註冊所有綁定。
     *
     * @return void
     */
    public function boot()
    {
        // 使用物件型態的視圖組件...
         view()->composer(
             'layouts.menu', 'App\Http\ViewComposers\PageComposer'
         );
        // 使用閉包型態的視圖組件...

        //把單位渲染到stocks底下所有程式
//        $for_units = [
//            'erp.basic.stock.create',
//            'erp.basic.stock.edit',
//        ];
//        view()->composer($for_units, function ($view) {
//            //$view->with('ids', OptionRepository::getAllOptionsId('warehouses'));
//            $view->with('units', OptionRepository::getAllOptionsPair('units'));
//            $view->with('stock_classes', OptionRepository::getAllOptionsPair('stock_classes'));
//        });
    }

    /**
     * 註冊服務提供者。
     *
     * @return void
     */
    public function register()
    {
        //
    }
}