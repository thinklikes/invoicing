<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Purchase\BillOfPurchaseRepository;
use App\Purchase\BillOfPurchaseCreator;
use App\Purchase\BillOfPurchaseUpdater;
use Config;
use Carbon\Carbon;
use App\Contracts\FormRequestInterface;

class BillOfPurchaseController extends Controller
{
    protected $OrderRepository;
    protected $OrderCreator;
    protected $orderMasterInputName = 'billOfPurchaseMaster';
    protected $orderDetailInputName = 'billOfPurchaseDetail';
    protected $className = 'BillOfPurchaseController';
    protected $routeName = 'billsOfPurchase';
    protected $ordersPerPage = 15;
    /**
     * SupplierController constructor.
     *
     * @param SupplierRepository $supplierRepository
     */
    public function __construct(
        BillOfPurchaseRepository $OrderRepository,
        BillOfPurchaseCreator $OrderCreator)
    {
        $this->OrderRepository = $OrderRepository;
        $this->OrderCreator    = $OrderCreator;

        Config::set('className', $this->className);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->routeName.'.index', [
            'orders' => $this->OrderRepository->getOrdersOnePage($this->ordersPerPage)
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
            'new_master_code'           => $this->OrderRepository->getNewOrderCode(),
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
    public function store(FormRequestInterface $request)
    {
        //抓出使用者輸入的資料
        $orderMaster = $request->input($this->orderMasterInputName);
        $orderDetail = $request->input($this->orderDetailInputName);

        if (! $this->OrderCreator->create($orderMaster, $orderDetail)) {
            return $this->orderCreatedError();
        }

        return $this->orderCreated($orderMaster['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $orderMaster = $this->OrderRepository->getOrderMaster($code);
        $orderDetail = $this->OrderRepository->getOrderDetail($code);
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
            $orderMaster = $this->OrderRepository
                ->getOrderMaster($code);
            $orderDetail = $this->OrderRepository
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
        $old_OrderMaster = $this->OrderRepository
            ->getOrderMaster($code);
        $old_OrderDetail = $this->OrderRepository
            ->getOrderDetail($code);
        foreach ($old_OrderDetail as $key => $value) {
            $this->stockWarehouseRepository->updateInventory(
                -$value['quantity'],
                $value['stock_id'],
                $old_OrderMaster['warehouse_id']
            );
        }

        $OrderMaster = $request->input($this->orderMasterInputName);
        $OrderDetail = $request->input($this->orderDetailInputName);

        //先存入表頭
        $this->OrderRepository->updateOrderMaster(
            $OrderMaster, $code
        );

        //清空表身
        $this->OrderRepository->deleteOrderDetail($code);

        foreach ($OrderDetail as $key => $value) {
            if ($value['quantity'] == 0 || $value['quantity'] == "") {
                continue;
            }
            //存入表身
            $this->OrderRepository->updateOrderDetail(
                $value, $code
            );
            //更新數量
            $this->stockWarehouseRepository->updateInventory(
                $value['quantity'],
                $value['stock_id'],
                $OrderMaster['warehouse_id']
            );
        }
        if (! $this->OrderCreator->update($orderMaster, $orderDetail)) {
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
        $old_OrderMaster = $this->OrderRepository
            ->getOrderMaster($code);
        $old_OrderDetail = $this->OrderRepository
            ->getOrderDetail($code);
        foreach ($old_OrderDetail as $key => $value) {
            $this->stockWarehouseRepository->updateInventory(
                -$value['quantity'],
                $value['stock_id'],
                $old_OrderMaster['warehouse_id']
            );
        }

        //將這張單作廢
        $this->OrderRepository->deleteOrderMaster($code);
        //$this->OrderRepository->deleteOrderDetail($code);
        return redirect()->action($this->className.'@index')
            ->with('status', [0 => '進貨單已刪除!']);
    }

    public function orderCreated($code)
    {
        return redirect()
            ->action(
                $this->className.'@show',
                ['code' => $code]
            )
            ->with('status', ['進貨單已新增!']);
    }

    public function orderCreatedError()
    {
        return redirectBack()
            ->with('error', ['進貨單開單失敗!']);
    }

    public function orderUpdated($code)
    {
        return redirect()
            ->action(
                $this->className.'@show',
                ['code' => $code]
            )
            ->with('status', [0 => '進貨單已更新!']);
    }

    public function orderUpdatedError()
    {
        return redirectBack()
            ->with('error', ['進貨單更新失敗!']);
    }
}