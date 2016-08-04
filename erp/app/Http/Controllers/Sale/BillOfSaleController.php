<?php

namespace App\Http\Controllers\Sale;

use App;
use App\Contracts\FormRequestInterface;
use App\Http\Requests\DestroyRequest;
use App\Http\Controllers\BasicController;
use BillOfSale\BillOfSaleRepository as Order;
use BillOfSale\BillOfSaleService as Service;
use Illuminate\Http\Request;

class BillOfSaleController extends BasicController
{
    protected $order;
    protected $service;
    private $orderMasterInputName = 'billOfSaleMaster';
    private $orderDetailInputName = 'billOfSaleDetail';
    private $routeName = 'erp.sale.billOfSale';
    private $ordersPerPage = 15;
    /**
     * CompanyController constructor.
     *
     * @param CompanyRepository $companyRepository
     */
    public function __construct(
        Order $order,
        Service $service
    ) {
        $this->order   = $order;
        $this->service = $service;
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
        switch ($data_mode) {
            case 'getReceivableByCompanyId':
                $orderMaster = $this->order->getReceivableByCompanyId($code);
                break;
            default:
                # code...
                break;
        }
        return response()->json($orderMaster->all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->routeName.'.index', [
            'orders' => $this->order->getOrdersPaginated($this->ordersPerPage)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $master = $request->old($this->masterInputName);

        $details = $request->old($this->detailInputName);

        return view($this->routeName.'.create',
            $this->service->getDataBeforeShown($master, $details));
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
        $master = $request->input($this->orderMasterInputName);
        $details = $request->input($this->orderDetailInputName);

        return $this->service->create($this, $master, $details);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $orderMaster = $this->order->getOrderMaster($code);
        //$orderMaster->company_code = $orderMaster->company->code;
        $orderMaster->company_name = $orderMaster->company->company_name;

        $orderDetail = $this->order->getOrderDetail($code);
        foreach ($orderDetail as $key => $value) {
            $orderDetail[$key]->stock_code = $orderDetail[$key]->stock->code;
            $orderDetail[$key]->stock_name = $orderDetail[$key]->stock->name;
            $orderDetail[$key]->unit = $orderDetail[$key]->stock->unit->comment;
        }
        return view($this->routeName.'.show', [
            $this->orderMasterInputName => $orderMaster,
            $this->orderDetailInputName => $orderDetail,
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
        if ($request->old()) {
            $orderMaster = $request->old($this->orderMasterInputName);

            $orderMaster['created_at'] = $this->order
                ->getOrderMasterfield('created_at', $code);

            $orderMaster['received_amount'] = $this->order
                ->getOrderMasterfield('received_amount', $code);

            $orderMaster['code'] = $code;

            $orderDetail = $request->old($this->orderDetailInputName);
        } else {
            $orderMaster = $this->order->getOrderMaster($code);
            //$orderMaster->company_code = $orderMaster->company->code;
            $orderMaster->company_name = $orderMaster->company->company_name;

            $orderMaster->company_code = $orderMaster->company->company_code;

            $orderDetail = $this->order->getOrderDetail($code);
            foreach ($orderDetail as $key => $value) {
                $orderDetail[$key]->stock_code = $orderDetail[$key]->stock->code;
                $orderDetail[$key]->stock_name = $orderDetail[$key]->stock->name;
                $orderDetail[$key]->unit = $orderDetail[$key]->stock->unit->comment;
            }
        }

        return view($this->routeName.'.edit', [
            $this->orderMasterInputName => $orderMaster,
            $this->orderDetailInputName => $orderDetail,
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

        $orderMaster = $request->input($this->orderMasterInputName);
        $orderDetail = $request->input($this->orderDetailInputName);

        return $this->service->update($this, $orderMaster, $orderDetail, $code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRequest $request, $code)
    {
        return $this->service->delete($this, $code);
    }

    public function printing($code)
    {
        return view($this->routeName.'.printing', [
            $this->orderMasterInputName => $this->order->getOrderMaster($code),
            $this->orderDetailInputName => $this->order->getOrderDetail($code),
        ]);
    }

}