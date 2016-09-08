<?php

namespace App\Http\Controllers\Erp;

use App;
//use Erp\BarcodePrinter\BarcodePrinterInterface;
//use Erp\Services\ErpServiceInterface;
use Erp\Services\CRUDServiceInterface as Service;
use App\Contracts\FormRequestInterface;
use Schema;
use App\Http\Requests\DestroyRequest;
use App\Http\Controllers\BasicController;
use Illuminate\Http\Request;

class CRUDController extends BasicController
{
    private $service;
    /**
     * 引入的App名稱
     * @var string
     */
    private $app_name = '';
    /**
     * 表單表頭的陣列名稱
     * @var string
     */
    private $headName = '';
    /**
     * 表單表身的陣列名稱
     * @var string
     */
    private $bodyName = '';

    public function __construct(Request $request)
    {
        $this->middleware('page_auth');

        $this->app_name = explode("/", $request->path())[0];

        $this->className = 'Erp\CRUDController';

        $this->service = App::make(
            Service::class,
            ['app_name' => $this->app_name]);

        $this->headName = $this->service->getProperty('headName');

        $this->bodyName = $this->service->getProperty('bodyName');
    }

    // public function printBarcode()
    // {
    //     $item = $service->getAllItemNamesAndCodes();

    //     return $this->barcodePrinter->printBarcode($item);
    // }

    // public function json(Request $request)
    // {
    //     $param = $request->input();
    //     return $this->orderRepository->getCompanyJson($param);
    // }
    /**
     * 首頁
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param = $request->input('sidebar');

        return view('erp.crud_index', [
            'chname' => $this->service->getProperty('chname'),
            'app_name' => $this->app_name,
            'sidebar' => [
                'title' => '搜尋',
                'fields' => $this->service->getProperty('sidebarFields'),
                'data' => $param,
                'button_text' => '搜尋'
            ],
            'master' => [
                'fields' => $this->service->getProperty('indexFields'),
                'data' => $this->service->getDataPaginated($param)
            ]
        ]);
    }

    /**
     * 資料建立界面
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $this->service->reformDataBeforeCreate(
            $request->old($this->headName));

        return view('erp.crud_create', [
            'chname' => $this->service->getProperty('chname'),
            'app_name' => $this->app_name,
            'headName' => $this->headName,
            'bodyName' => $this->bodyName,
            //將必填欄位的陣列轉為一維陣列
            'required' => $this->service->getProperty('required'),
            'head' => [
                'fields' => $this->service->getProperty('formFields')['head'],
                'data' => $data,
            ],
            'body' => []
        ]);
    }

    /**
     * 存入資料
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $request = App::make(
            FormRequestInterface::class,
            ['className' => $this->app_name]);
        //抓出使用者輸入的資料
        $head = $request->input($this->headName);

        $body = $request->input($this->bodyName);

        return $this->service->create($this, $head, $body);
    }

    /**
     * 檢視資料界面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $data = $this->service->getDataByCode($code);

        return view('erp.crud_show', [
            'code' => $code,
            'chname' => $this->service->getProperty('chname'),
            'app_name' => $this->app_name,
            'headName' => $this->headName,
            'bodyName' => $this->bodyName,
            'head' => [
                'fields' => $this->service->getProperty('showFields')['head'],
                'data' => $data,
            ],
            'body' => []
        ]);
    }

    /**
     * 資料編輯界面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function edit(Request $request, $code)
    {
        $data = $request->old()
            ? $request->old($this->headName)
            : $this->service->getDataByCode($code);

        $data = $this->service->reformDataBeforeEdit($data);

        return view('erp.crud_edit', [
            'code' => $code,
            'chname' => $this->service->getProperty('chname'),
            'app_name' => $this->app_name,
            'headName' => $this->headName,
            'bodyName' => $this->bodyName,
            'required' => $this->service->getProperty('required'),
            'head' => [
                'fields' => $this->service->getProperty('formFields')['head'],
                'data' => $data,
            ],
            'body' => []
        ]);
    }

    /**
     * 更新資料
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($code)
    {
        $request = App::make(
            FormRequestInterface::class,
            ['className' => $this->app_name]);

        $head = $request->input($this->headName);

        $body = $request->input($this->bodyName);

        return $this->service->update($code, $this, $head, $body);
    }

    /**
     * 刪除資料
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($code)
    {
        return $this->service->delete($this, $code);
    }
}
