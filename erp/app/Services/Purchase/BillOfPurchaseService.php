<?php
namespace App\Services\Purchase;

use App\Repositories\Purchase\BillOfPurchaseRepository as OrderRepository;
use App\Repositories\StockWarehouseRepository as StockWarehouse;
use Illuminate\Support\MessageBag;
use App\Presenters\OrderCalculator;

class BillOfPurchaseService
{
    protected $orderRepository;
    protected $stock;

    public function __construct(
        OrderRepository $orderRepository,
        StockWarehouse $stock,
        OrderCalculator $calculator
    ) {
        $this->orderRepository = $orderRepository;
        $this->stock           = $stock;
        $this->calculator      = $calculator;
    }

    public function create($listener, $orderMaster, $orderDetail)
    {
        $isCreated = true;
        $code = $this->orderRepository->getNewOrderCode();
        $orderMaster['code'] = $code;

        $this->calculator->setOrderMaster($orderMaster);
        $this->calculator->setOrderDetail($orderDetail);
        $this->calculator->calculate();

        $orderMaster['total_amount'] = $this->calculator->getTotalAmount();
        //新增進貨單表頭
        $isCreated = $isCreated && $this->orderRepository->storeOrderMaster($orderMaster);

        //新增進貨單表身
        foreach($orderDetail as $key => $value) {
            if ($value['quantity'] == 0 || $value['quantity'] == "") {
                continue;
            }
            $value['master_code'] = $code;
            //存入表身
            $isCreated = $isCreated && $this->orderRepository
                ->storeOrderDetail($value);
            //更新倉庫數量
            $this->stock->updateInventory(
                $value['quantity'],
                $value['stock_id'],
                $orderMaster['warehouse_id']
            );
        }

        //return $isCreated;
        if (!$isCreated) {
            return $listener->orderCreatedErrors(
                new MessageBag(['進貨單開單失敗!'])
            );
        }
        return $listener->orderCreated(
            new MessageBag(['進貨單已新增!']), $code
        );
    }

    public function update($listener, $orderMaster, $orderDetail, $code)
    {
        $isUpdated = true;

        //先存入表頭
        $isUpdated = $isUpdated && $this->orderRepository->updateOrderMaster(
            $orderMaster, $code
        );
        //將庫存數量恢復到未開單前
        $this->retrunStockInventory($code);
        //dd($isUpdated);
        //清空表身
        $this->orderRepository->deleteOrderDetail($code);

        foreach ($orderDetail as $key => $value) {
            if ($value['quantity'] == 0 || $value['quantity'] == "") {
                continue;
            }
            $value['master_code'] = $code;
            //存入表身
            $isUpdated = $isUpdated && $this->orderRepository->storeOrderDetail($value);
            //更新數量
            $this->stock->updateInventory(
                $value['quantity'],
                $value['stock_id'],
                $orderMaster['warehouse_id']
            );
        }

        //return $isUpdated;
        if (!$isUpdated) {
            return $listener->orderUpdatedErrors(
                new MessageBag(['進貨單更新失敗!'])
            );
        }
        return $listener->orderUpdated(
            new MessageBag(['進貨單已更新!']), $code
        );
    }

    public function delete($listener, $code)
    {
        $isDeleted = true;

        //將庫存數量恢復到未開單前
        $this->retrunStockInventory($code);

        //將這張單作廢
        $isDeleted = $isDeleted && $this->orderRepository->deleteOrderMaster($code);
        //$this->orderRepository->deleteOrderDetail($code);

        if (!$isDeleted) {
            return $listener->orderDeletedErrors(
                new MessageBag(['進貨單刪除失敗!'])
            );
        }
        return $listener->orderDeleted(
            new MessageBag(['進貨單已刪除!']), $code
        );
    }

    public function retrunStockInventory($code) {
        //將庫存數量恢復到未開單前
        $old_OrderMaster = $this->orderRepository->getOrderMaster($code);
        $old_OrderDetail = $this->orderRepository->getOrderDetail($code);
        foreach ($old_OrderDetail as $key => $value) {
            $this->stock->updateInventory(
                -$value['quantity'],
                $value['stock_id'],
                $old_OrderMaster['warehouse_id']
            );
        }
    }
}