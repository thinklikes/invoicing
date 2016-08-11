<?php

namespace App\Http\Controllers\Erp;

use App;
use Erp\BarcodePrinter\BarcodePrinterInterface;
use Erp\Services\ErpServiceInterface;
use App\Contracts\FormRequestInterface;

use App\Http\Requests\DestroyRequest;
use App\Http\Controllers\BasicController;
use Illuminate\Http\Request;

class ErpController extends BasicController
{
    protected $service;
    private $app_name = '';
    private $masterInputName = '';
    private $routeName = 'erp.basic.company';
    private $ordersPerPage = 15;
    private $barcodePrinter;
    public function __construct(Request $request)
    {
        $url = $request->url();

        $this->app_name = explode('/', $url)[3];
        $this->masterInputName = $this->app_name;

        $this->service = App::make(
            'Erp\Services\ErpServiceInterface',
            ['app_name' => $this->app_name]);

        $this->barcodePrinter = App::make(
            'Erp\BarcodePrinter\BarcodePrinterInterface',
            ['app_name' => $this->app_name]);

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
        $param = [
            ''
        ];

        return $this->service->getAppIndexPage();
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create(Request $request)
    // {
    //     return view($this->routeName.'.create', [
    //         $this->orderMasterInputName => $request->old($this->orderMasterInputName),
    //     ]);
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(FormRequestInterface $request)
    // {
    //     //抓出使用者輸入的資料
    //     $orderMaster = $request->input($this->orderMasterInputName);

    //     return $this->service->create($this, $orderMaster);
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     $orderMaster = $this->orderRepository->getCompanyById($id);

    //     return view($this->routeName.'.show', [
    //         $this->orderMasterInputName => $orderMaster
    //     ]);
    // }

    // *
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response

    // public function edit(Request $request, $id)
    // {
    //     if ($request->old()) {
    //         $orderMaster = $request->old($this->orderMasterInputName);

    //         $orderMaster['auto_id'] = $id;
    //     } else {
    //         $orderMaster = $this->orderRepository->getCompanyById($id);

    //     }

    //     return view($this->routeName.'.edit', [
    //         $this->orderMasterInputName => $orderMaster,
    //     ]);
    // }

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
