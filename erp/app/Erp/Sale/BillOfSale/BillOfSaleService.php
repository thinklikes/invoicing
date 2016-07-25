<?php
namespace BillOfSale;

use BillOfSale\BillOfSaleRepository as OrderRepository;
use Stock\StockWarehouseRepository as StockWarehouse;
use StockOutLogs\StockOutLogsRepository as StockOutLogs;
use Illuminate\Support\MessageBag;
use App\Presenters\OrderCalculator;

class BillOfSaleService
{
    protected $orderRepository, $calculator, $stockOutLogs;
    protected $stock;

    public function __construct(
        OrderRepository $orderRepository,
        StockWarehouse $stock,
        OrderCalculator $calculator,
        StockOutLogs $stockOutLogs
    ) {
        $this->orderRepository = $orderRepository;
        $this->stock           = $stock;
        $this->calculator      = $calculator;
        $this->stockOutLogs    = $stockOutLogs;
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
        //新增銷貨單表頭
        $isCreated = $isCreated && $this->orderRepository->storeOrderMaster($orderMaster);

        //新增銷貨單表身
        foreach($orderDetail as $key => $value) {
            if ($value['quantity'] == 0 || $value['quantity'] == "") {
                continue;
            }
            $value['master_code'] = $code;
            //存入表身
            $isCreated = $isCreated && $this->orderRepository
                ->storeOrderDetail($value);
            //更新倉庫數量，因為是銷貨，扣掉數量
            $this->stock->incrementInventory(
                -$value['quantity'],
                $value['stock_id'],
                $orderMaster['warehouse_id']
            );
            //添加一筆庫存出庫記錄
            $this->stockOutLogs->addStockOutLog(
                'billOfSale',
                $value['master_code'],
                $orderMaster['warehouse_id'],
                $value['stock_id'],
                -$value['quantity']
            );
        }

        //return $isCreated;
        if (!$isCreated) {
            return $listener->orderCreatedErrors(
                new MessageBag(['銷貨單開單失敗!'])
            );
        }
        return $listener->orderCreated(
            new MessageBag(['銷貨單已新增!']), $code
        );
    }

    public function update($listener, $orderMaster, $orderDetail, $code)
    {
        $isUpdated = true;

        //將庫存數量恢復到未開單前
        $this->revertStockInventory($code);
        //移除本單據的庫存出庫記錄
        $this->stockOutLogs->deleteStockOutLogsByOrderCode('billOfSale', $code);

        $this->calculator->setOrderMaster($orderMaster);
        $this->calculator->setOrderDetail($orderDetail);
        $this->calculator->calculate();

        $orderMaster['total_amount'] = $this->calculator->getTotalAmount();
        //先存入表頭
        $isUpdated = $isUpdated && $this->orderRepository->updateOrderMaster(
            $orderMaster, $code
        );

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
            $this->stock->incrementInventory(
                -$value['quantity'],
                $value['stock_id'],
                $orderMaster['warehouse_id']
            );
            //添加一筆庫存出庫記錄
            $this->stockOutLogs->addStockOutLog(
                'billOfSale',
                $value['master_code'],
                $orderMaster['warehouse_id'],
                $value['stock_id'],
                -$value['quantity']
            );
        }

        //return $isUpdated;
        if (!$isUpdated) {
            return $listener->orderUpdatedErrors(
                new MessageBag(['銷貨單更新失敗!'])
            );
        }
        return $listener->orderUpdated(
            new MessageBag(['銷貨單已更新!']), $code
        );
    }

    public function delete($listener, $code)
    {
        $isDeleted = true;

        //將庫存數量恢復到未開單前
        $this->revertStockInventory($code);
        //移除本單據的庫存出庫記錄
        $this->stockOutLogs->deleteStockOutLogsByOrderCode('billOfSale', $code);
        //將這張單作廢
        $isDeleted = $isDeleted && $this->orderRepository->deleteOrderMaster($code);
        //$this->orderRepository->deleteOrderDetail($code);

        if (!$isDeleted) {
            return $listener->orderDeletedErrors(
                new MessageBag(['銷貨單刪除失敗!'])
            );
        }
        return $listener->orderDeleted(
            new MessageBag(['銷貨單已刪除!']), $code
        );
    }

    public function revertStockInventory($code) {
        //將庫存數量恢復到未開單前
        $old_OrderMaster = $this->orderRepository->getOrderMaster($code);
        $old_OrderDetail = $this->orderRepository->getOrderDetail($code);
        //因為是銷貨，把數量加回來

        foreach ($old_OrderDetail as $key => $value) {
            $this->stock->incrementInventory(
                $value['quantity'],
                $value['stock_id'],
                $old_OrderMaster['warehouse_id']
            );
        }
    }
}