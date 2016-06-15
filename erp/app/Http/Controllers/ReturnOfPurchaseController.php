<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ReturnOfPurchaseRepository;
use App\Repositories\StockWarehouseRepository;
use App\Contracts\FormRequestInterface;
use Config;
use Carbon\Carbon;

class ReturnOfPurchaseController extends Controller
{
    protected $OrderRepository;
    protected $warehouseRepository;
    protected $stockWarehouseRepository;
    protected $orderMasterInputName = 'returnOfPurchaseMaster';
    protected $orderDetailInputName = 'returnOfPurchaseDetail';
    protected $className = 'ReturnOfPurchaseController';
    protected $routeName = 'returnsOfPurchase';
    /**
     * SupplierController constructor.
     *
     * @param SupplierRepository $supplierRepository
     */
    public function __construct(ReturnOfPurchaseRepository $OrderRepository,
        StockWarehouseRepository $stockWarehouseRepository)
    {
        $this->OrderRepository          = $OrderRepository;
        $this->stockWarehouseRepository = $stockWarehouseRepository;

        Config::set('className', $this->className);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->OrderRepository->getOrdersOnePage();
        return view($this->routeName.'.index', [
            'orders'    => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //抓出新單號
        $new_master_code = $this->OrderRepository->getNewOrderCode();

        return view($this->routeName.'.create', [
            'new_master_code'           => $new_master_code,
            'created_at'                => Carbon::now(),
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

        $code = $orderMaster['code'];

        //新增進貨單表頭
        $this->OrderRepository->storeOrderMaster($orderMaster);

        //新增進貨單表身
        foreach($orderDetail as $key => $value) {
            if ($value['quantity'] == 0 || $value['quantity'] == "") {
                continue;
            }
            //存入表身
            $this->OrderRepository->storeOrderDetail(
                $value, $code
            );
            //更新倉庫數量
            $this->stockWarehouseRepository->updateInventory(
                $value['quantity'],
                $value['stock_id'],
                $orderMaster['warehouse_id']
            );
        }
        return redirect()
            ->action(
                $this->className.'@show',
                ['code' => $code]
            )
            ->with('status', [0 => '進貨單已新增!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        return view($this->routeName.'.show', [
            'code'                 => $code,
            'created_at'           => $orderMaster->created_at,
            $this->orderMasterInputName => $this->OrderRepository
                ->getOrderMaster($code),
            $this->orderDetailInputName => $this->OrderRepository
                ->getOrderDetail($code),
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
        return redirect()->action($this->className.'@show', ['code' => $code])
            ->with('status', [0 => '進貨單已更新!']);
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
}