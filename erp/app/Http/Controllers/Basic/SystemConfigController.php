<?php

namespace App\Http\Controllers\Basic;

use App\Repositories\OptionRepository;
use App\Http\Controllers\Controller;
use App\Contracts\FormRequestInterface;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\BasicController;

class SystemConfigController extends BasicController
{
    public function __construct()
    {
        $this->setFullClassName();
    }
    /**
     * 本控制器的index方法
     * @return page
     */
    public function index()
    {
        return view('system_configs.index', [
            'configs' => OptionRepository::getAllConfigs()
        ]);
    }
    // /**
    //  * 本控制器的edit方法
    //  * @return page
    //  */
    public function edit()
    {
        //$EditRoute = route('SystemConfigsEditor');
        return view('system_configs.edit', [
            'configs' => OptionRepository::getAllConfigs()
        ]);
    }
    // /**
    //  * 本控制器的update方法
    //  * 執行前會先給ErpRequest驗證
    //  * 若驗證有誤則導回前頁
    //  * 異動完後導回/system_configs
    //  * @return page
    //  */
    public function update(FormRequestInterface $request)
    {
        OptionRepository::setSystemConfigs($request->input('configs'));

        return redirect()->action(
                "$this->className@index")
            ->with(['status' => new MessageBag(['系統設定已更新'])]);
    }
}
