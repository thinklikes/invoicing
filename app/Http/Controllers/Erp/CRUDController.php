<?php

namespace App\Http\Controllers\Erp;

use App;
//use Erp\BarcodePrinter\BarcodePrinterInterface;
//use Erp\Services\ErpServiceInterface;
use Erp\Services\ErpServiceInterface as Service;
use App\Contracts\FormRequestInterface;
use Schema;
use App\Http\Requests\DestroyRequest;
use App\Http\Controllers\BasicController;
use Illuminate\Http\Request;

class CRUDController extends BasicController
{
    private $service;
    private $app_name = '';
    private $headName = '';
    private $bodyName = '';
    //private $routeName = 'erp.basic.company';
    private $barcodePrinter;

    public function __construct(Request $request)
    {

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
     * Display a listing of the resource.
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
                'data' => $this->service->getAppIndexData($param)
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('erp.crud_create', [
            'chname' => $this->service->getProperty('chname'),
            'app_name' => $this->app_name,
            'headName' => $this->headName,
            'required' => $this->service->getProperty('required'),
            'head' => [
                'fields' => $this->service->getProperty('headFields'),
                'data' => $request->old($this->headName),
            ],
            'body' => []
        ]);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function store()
    {
        $request = App::make(
            FormRequestInterface::class,
            ['className' => $this->app_name]);
        //抓出使用者輸入的資料
        $master = $request->input($this->headName);

        return $this->service->create($this, $master);
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function show($code)
    {
        $data = $this->service->getDataByCode($code);

        return view('erp.crud_show', [
            'code' => $code,
            'chname' => $this->service->getProperty('chname'),
            'app_name' => $this->app_name,
            'headName' => $this->headName,
            'required' => $this->service->getProperty('required'),
            'head' => [
                'fields' => $this->service->getProperty('headFields'),
                'data' => $data,
            ],
            'body' => []
        ]);
    }

    // *
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response

    public function edit(Request $request, $id)
    {
        $data = $this->service->getDataByCode($code);
        return view('erp.crud_create', [
            'chname' => $this->service->getProperty('chname'),
            'app_name' => $this->app_name,
            'headName' => $this->headName,
            'required' => $this->service->getProperty('required'),
            'head' => [
                'fields' => $this->service->getProperty('headFields'),
                'data' => $request->old($this->headName),
            ],
            'body' => []
        ]);
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(FormRequestInterface $request, $id)
    // {

    //     $orderMaster = $request->input($this->orderMasterInputName);

    //     return $this->service->update($this, $orderMaster, $id);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(DestroyRequest $request, $code)
    // {
    //     return $this->service->delete($this, $code);
    // }
}
