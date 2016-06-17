<?php

namespace App\Http\Controllers\Purchase;

use App;
use App\Contracts\FormRequestInterface;
use App\Http\Controllers\BasicController;
use App\Purchase\BillOfPurchase\BillOfPurchaseRepository as OrderRepository;
use App\Purchase\BillOfPurchase\BillOfPurchaseCreator as OrderCreator;
use App\Purchase\BillOfPurchase\BillOfPurchaseUpdater as OrderUpdater;
use App\Purchase\BillOfPurchase\BillOfPurchaseDeleter as OrderDeleter;
use Config;
use Illuminate\Http\Request;

class BillOfPurchaseController extends BasicController
{
    protected $orderRepository;
    protected $orderCreator;
    protected $orderUpdater;
    protected $orderDeleter;
    private $orderMasterInputName = 'billOfPurchaseMaster';
    private $orderDetailInputName = 'billOfPurchaseDetail';
    private $routeName = 'billsOfPurchase';
    private $ordersPerPage = 15;
    /**
     * SupplierController constructor.
     *
     * @param SupplierRepository $supplierRepository
     */
    public function __construct(
        OrderRepository $orderRepository,
        OrderCreator $orderCreator
        )
    {
        $this->orderRepository = $orderRepository;
        $this->orderCreator    = $orderCreator;
        //$this->orderUpdater    = $orderUpdater;
        //$this->orderDeleter    = $orderDeleter;
        $this->setFullClassName();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->routeName.'.index', [
            'orders' => $this->orderRepository->getOrdersOnePage($this->ordersPerPage)
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
        $request = App::make(
            'App\Contracts\FormRequestInterface',
            ['className' => $this->className]
        );
        //抓出使用者輸入的資料
        $orderMaster = $request->input($this->orderMasterInputName);
        $orderDetail = $request->input($this->orderDetailInputName);

        return $this->orderCreator->create($this, $orderMaster, $orderDetail);
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
        $orderDetail = $this->orderRepository->getOrderDetail($code);
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
        if (count($request->old($this->orderMasterInputName)) > 0 ||
            $request->old($this->orderDetailInputName) > 0)
        {
            $orderMaster = $request->old($this->orderMasterInputName);
            $orderDetail = $request->old($this->orderDetailInputName);
        } else {
            $orderMaster = $this->orderRepository
                ->getOrderMaster($code);
            $orderDetail = $this->orderRepository
                ->getOrderDetail($code);
        }

        return view($this->routeName.'.edit', [
            'code'                      => $code,
            'created_at'                => $orderMaster->created_at,
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
    public function update(FormRequestInterface $request, $code)
    {
        //將庫存數量恢復到未開單前
        $old_OrderMaster = $this->orderRepository
            ->getOrderMaster($code);
        $old_OrderDetail = $this->orderRepository
            ->getOrderDetail($code);
        foreach ($old_OrderDetail as $key => $value) {
            $this->stockWarehouseRepository->updateInventory(
                -$value['quantity'],
                $value['stock_id'],
                $old_OrderMaster['warehouse_id']
            );
        }

        $orderMaster = $request->input($this->orderMasterInputName);
        $orderDetail = $request->input($this->orderDetailInputName);

        //先存入表頭
        $this->orderRepository->updateOrderMaster(
            $orderMaster, $code
        );

        //清空表身
        $this->orderRepository->deleteOrderDetail($code);

        foreach ($orderDetail as $key => $value) {
            if ($value['quantity'] == 0 || $value['quantity'] == "") {
                continue;
            }
            //存入表身
            $this->orderRepository->updateOrderDetail(
                $value, $code
            );
            //更新數量
            $this->stockWarehouseRepository->updateInventory(
                $value['quantity'],
                $value['stock_id'],
                $orderMaster['warehouse_id']
            );
        }
        if (! $this->orderCreator->update($orderMaster, $orderDetail)) {
            return $this->orderCreatedError();
        }
        return $this->orderUpdated($code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($code)
    {
        //將庫存數量恢復到未開單前
        $old_OrderMaster = $this->orderRepository
            ->getOrderMaster($code);
        $old_OrderDetail = $this->orderRepository
            ->getOrderDetail($code);
        foreach ($old_OrderDetail as $key => $value) {
            $this->stockWarehouseRepository->updateInventory(
                -$value['quantity'],
                $value['stock_id'],
                $old_OrderMaster['warehouse_id']
            );
        }

        //將這張單作廢
        $this->orderRepository->deleteOrderMaster($code);
        //$this->orderRepository->deleteOrderDetail($code);
        return redirect()->action($this->className.'@index')
            ->with('status', [0 => '進貨單已刪除!']);
    }

    public function orderCreated($status, $code)
    {
        return redirect()->action($this->className.'@show', ['code' => $code])
            ->with(['status' => $status]);
    }

    public function orderCreatedErrors($errors)
    {
        return back()->withInput()->withErrors($errors);
    }

    public function orderUpdated($status, $code)
    {
        return redirect()->action($this->className.'@show', ['code' => $code])
            ->with('status', $status);
    }

    public function orderUpdatedError()
    {
        return redirectBack()
            ->with('errors', ['進貨單更新失敗!']);
    }
}