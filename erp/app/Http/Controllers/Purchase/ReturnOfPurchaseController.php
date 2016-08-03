<?php

namespace App\Http\Controllers\Purchase;

use App;
use App\Contracts\FormRequestInterface;
use App\Http\Requests\DestroyRequest;
use App\Http\Controllers\BasicController;
use ReturnOfPurchase\ReturnOfPurchaseRepository as OrderRepository;
use ReturnOfPurchase\ReturnOfPurchaseService as orderService;
use Config;
use Illuminate\Http\Request;

class ReturnOfPurchaseController extends BasicController
{
    protected $orderRepository;
    protected $orderService;
    private $orderMasterInputName = 'returnOfPurchaseMaster';
    private $orderDetailInputName = 'returnOfPurchaseDetail';
    private $routeName = 'erp.purchase.returnOfPurchase';
    private $ordersPerPage = 15;
    /**
     * SupplierController constructor.
     *
     * @param SupplierRepository $supplierRepository
     */
    public function __construct(
        OrderRepository $orderRepository,
        OrderService $orderService
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderService    = $orderService;
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
            case 'getPayableBySupplierId':
                $orderMaster = $this->orderRepository->getPayableBySupplierId($code);
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
            'orders' => $this->orderRepository->getOrdersPaginated($this->ordersPerPage)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view($this->routeName.'.create', [
            'new_master_code'           => $this->orderRepository->getNewOrderCode(),
            $this->orderMasterInputName => $request->old($this->orderMasterInputName),
            $this->orderDetailInputName => $request->old($this->orderDetailInputName),
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
        $orderMaster = $request->input($this->orderMasterInputName);
        $orderDetail = $request->input($this->orderDetailInputName);

        return $this->orderService->create($this, $orderMaster, $orderDetail);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $orderMaster = $this->orderRepository->getOrderMaster($code);
        $orderMaster->supplier_code = $orderMaster->supplier->code;
        $orderMaster->supplier_name = $orderMaster->supplier->name;

        $orderDetail = $this->orderRepository->getOrderDetail($code);
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
        if ($request->old($this->orderMasterInputName)) {
            $orderMaster = $request->old($this->orderMasterInputName);
            $orderMaster['created_at'] = $this->orderRepository
                ->getOrderMasterfield('created_at', $code);
            $orderMaster['code'] = $code;
        } else {
            $orderMaster = $this->orderRepository->getOrderMaster($code);
            $orderMaster->supplier_code = $orderMaster->supplier->code;
            $orderMaster->supplier_name = $orderMaster->supplier->name;
        }

        if ($request->old($this->orderDetailInputName)) {
            $orderDetail = $request->old($this->orderDetailInputName);
        } else {
            $orderDetail = $this->orderRepository->getOrderDetail($code);
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

        return $this->orderService->update($this, $orderMaster, $orderDetail, $code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRequest $request, $code)
    {
        return $this->orderService->delete($this, $code);
    }

    public function printing($code)
    {
        return view($this->routeName.'.printing', [
            $this->orderMasterInputName => $this->orderRepository->getOrderMaster($code),
            $this->orderDetailInputName => $this->orderRepository->getOrderDetail($code),
        ]);
    }

}