<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ErpRequest;

use App\Repositories\OptionRepository;

class SystemConfigController extends Controller
{
    public function __construct()
    {

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
    /**
     * 本控制器的edit方法
     * @return page
     */
    public function edit()
    {
        //$EditRoute = route('SystemConfigsEditor');
        return view('system_configs.edit', [
            'configs' => OptionRepository::getAllConfigs()
        ]);
    }
    /**
     * 本控制器的update方法
     * 執行前會先給ErpRequest驗證
     * 若驗證有誤則導回前頁
     * 異動完後導回/system_configs
     * @return page
     */
    public function update(ErpRequest $request)
    {
        // $messages = [
        //     'configs.website_title.required' => '我們需要知道網站名稱！',
        //     'configs.system_build_date.required' => '我們需要知道系統建立日期！',
        // ];
        // $validator = Validator::make($request->all(), [
        //     'configs.website_title' => 'required',
        //     'configs.system_build_date' => 'required',
        // ], $messages);

        //驗證後附加邏輯
        // $validator->after(function($validator) {
        //     //if ($validator->somethingElseIsInvalid()) {

        //     //}
        // });
        //$validator = Validator::make($request->all());
        //     $messages = $this->validate($request)->messages();
        // if ($validator->fails()) {
        //     return redirect()->back()
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }


        OptionRepository::setSystemConfigs($request->input('configs'));

        return redirect()->action('SystemConfigController@index')
                        ->with('status', [0 => '系統設定已更新']);
    }
}
