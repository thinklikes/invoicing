<?php

namespace App\Http\Controllers\Basic;

use Option\OptionRepository;
use App\Http\Controllers\Controller;
use App\Contracts\FormRequestInterface;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\BasicController;

class SystemConfigController extends BasicController
{
    private $routeName = 'erp.basic.system_config';

    private $app_names = [
        'company',              //客戶
        'supplier',             //供應商
        'stock',                //料品
        'unit',                 //單位
        'stock_class',          //料品類別
        'pay_way',              //付款方式
        'warehouse',            //倉庫
        'system_config',        //系統參數設定
        'billOfPurchase',       //進貨單
        'returnOfPurchase',     //進貨退回單
        'payment',              //付款單
        'payableWriteOff',      //應付帳款沖銷單
        'billOfSale',           //銷貨單
        'returnOfSale',         //銷貨退回單
        'receipt',              //收款單
        'receivableWriteOff',   //應收帳款沖銷單
        'stockAdjust',          //調整單
        'stockTransfer',        //轉倉單
    ];

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
        return view($this->routeName.'.index', [
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
        return view($this->routeName.'.edit', [
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
            ->with(['status' => new MessageBag(['系統參數已更新'])]);
    }

    public function updateLogs($page = 0)
    {
        //顯示git更新記錄
        if (!$page) {
            $page = 0;
        }
        $skip = 10 * $page;

        exec('git log -10 --skip='.$skip.' --format=%cd%s --date=iso --grep="\[visiable\]"'
            , $git_logs);
        //exec('whoami', $output);
        return view("$this->routeName.updateLogs", ['logs' => $git_logs]);
    }

    public function export()
    {

    }

    public function import()
    {
        # code...
    }

}
