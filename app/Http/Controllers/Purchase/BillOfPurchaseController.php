<?php

namespace App\Http\Controllers\Purchase;

use App;
use App\Contracts\FormRequestInterface;
use App\Http\Requests\DestroyRequest;
use App\Http\Controllers\BasicController;
use BillOfPurchase\BillOfPurchaseService as Service;
use Illuminate\Http\Request;
use Excel;
use PDF;

class BillOfPurchaseController extends BasicController
{
    protected $service;
    private $headName = 'billOfPurchaseMaster';
    private $bodyName = 'billOfPurchaseDetail';
    private $routeName = 'erp.purchase.billOfPurchase';
    private $countPerPage = 15;
    /**
     * SupplierController constructor.
     *
     * @param SupplierRepository $supplierRepository
     */
    public function __construct(
        Service $service
    ) {
        $this->middleware('page_auth');
        $this->service    = $service;
        $this->setFullClassName();
    }

    /**
     * 回傳Json格式的資料
     * @param  string $data_mode 資料類型
     * @param  string $code      搜尋的鍵值
     * @return Json            Json格式的資料
     */
    public function json($data_mode, $code)
    {
        $data = $this->service->getJsonDataByMode($data_mode, $code);

        return response()->json($data->all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->routeName.'.index', [
            'orders' => $this->service->showOrders($this->countPerPage)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $master = $request->old($this->headName);

        $details = $request->old($this->bodyName);

        $data = $this->service->getCreateFormData($master, $details);

        return view($this->routeName.'.create', [
            'new_master_code' => $data['new_master_code'],
            'headName' => $this->headName,
            'bodyName' => $this->bodyName,
            $this->headName => $data['master'],
            $this->bodyName => $data['details'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //驗證表單填入的資料
        $request = App::make(
            'App\Contracts\FormRequestInterface',
            ['className' => $this->className]
        );
        //抓出使用者輸入的資料
        $orderMaster = $request->input($this->headName);
        $orderDetail = $request->input($this->bodyName);

        return $this->service->create($this, $orderMaster, $orderDetail);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $data = $this->service->getShowTableData($code);

        return view($this->routeName.'.show', [
            $this->headName => $data['master'],
            $this->bodyName => $data['details'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $code)
    {
        $master = $request->old($this->headName);

        $details = $request->old($this->bodyName);

        $data = $this->service->getEditFormData($code, $master, $details);

        return view($this->routeName.'.edit', [
            'headName' => $this->headName,
            'bodyName' => $this->bodyName,
            $this->headName => $data['master'],
            $this->bodyName => $data['details'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($code)
    {
        //驗證表單填入的資料
        $request = App::make(
            'App\Contracts\FormRequestInterface',
            ['className' => $this->className]
        );

        $orderMaster = $request->input($this->headName);
        $orderDetail = $request->input($this->bodyName);

        return $this->service->update($this, $orderMaster, $orderDetail, $code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($code)
    {
        return $this->service->delete($this, $code);
    }

    public function printing(Request $request, $code)
    {

        $data = $this->service->getShowTableData($code);
        if ($request->is('billOfPurchase/'.$code.'/excel')) {
            Excel::create($this->routeName, function($excel) use (
                $data)
            {

                $excel->sheet('進貨單', function($sheet) use (
                    $data)
                {

                    $sheet->loadView('erp.purchase.order_printing',
                        [
                            'chname' => '進貨單',
                            'headName' => $this->headName,
                            'bodyName' => $this->bodyName,
                            $this->headName => $data['master'],
                            $this->bodyName => $data['details'],
                        ]
                    );

                });

            })->export('xls');
        } else if ($request->is('billOfPurchase/'.$code.'/pdf')) {
            return PDF::loadView('erp.purchase.order_printing',
                [
                    'chname' => '進貨單',
                    'headName' => $this->headName,
                    'bodyName' => $this->bodyName,
                    $this->headName => $data['master'],
                    $this->bodyName => $data['details'],
                ])
                ->stream();
                //->download($this->routeName.'.pdf');
        } else {
            return view('erp.purchase.order_printing', [
                'chname' => '進貨單',
                'headName' => $this->headName,
                'bodyName' => $this->bodyName,
                $this->headName => $data['master'],
                $this->bodyName => $data['details'],
            ]);
        }
    }
}