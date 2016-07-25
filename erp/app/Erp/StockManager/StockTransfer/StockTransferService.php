<?php
namespace StockTransfer;

use StockTransfer\StockTransferRepository as OrderRepository;
use Stock\StockWarehouseRepository as StockWarehouse;
use StockInLogs\StockInLogsRepository as StockInLogs;
use StockOutLogs\StockOutLogsRepository as StockOutLogs;
use Illuminate\Support\MessageBag;
use App\Presenters\OrderCalculator;

class StockTransferService
{
    protected $orderRepository, $stockInLogs, $stockOutLogs;
    protected $stock;

    public function __construct(
        OrderRepository $orderRepository,
        StockWarehouse $stock,
        StockInLogs $stockInLogs,
        StockOutLogs $stockOutLogs
    ) {
        $this->orderRepository = $orderRepository;
        $this->stock           = $stock;
        $this->stockInLogs     = $stockInLogs;
        $this->stockOutLogs    = $stockOutLogs;
    }

    public function create($listener, $orderMaster, $orderDetail)
    {
        $isCreated = true;
        $code = $this->orderRepository->getNewOrderCode();
        $orderMaster['code'] = $code;

        //新增轉倉單表頭
        $isCreated = $isCreated && $this->orderRepository->storeOrderMaster($orderMaster);

        //新增轉倉單表身
        foreach($orderDetail as $key => $value) {
            if ($value['quantity'] == 0 || $value['quantity'] == "") {
                continue;
            }
            $value['master_code'] = $code;
            //存入表身
            $isCreated = $isCreated && $this->orderRepository
                ->storeOrderDetail($value);
            //更新調出倉庫數量，因為是調出，所以扣掉數量
            $this->stock->incrementInventory(
                -$value['quantity'],
                $value['stock_id'],
                $orderMaster['from_warehouse_id']
            );
            //添加一筆庫存出庫記錄
            $this->stockOutLogs->addStockOutLog(
                'stockTransfer',
                $value['master_code'],
                $orderMaster['from_warehouse_id'],
                $value['stock_id'],
                -$value['quantity']
            );
            //更新調入倉庫數量，因為是調入，所以把數量加回來
            $this->stock->incrementInventory(
                $value['quantity'],
                $value['stock_id'],
                $orderMaster['to_warehouse_id']
            );
            //添加一筆庫存入庫記錄
            $this->stockInLogs->addStockInLog(
                'stockTransfer',
                $value['master_code'],
                $orderMaster['to_warehouse_id'],
                $value['stock_id'],
                $value['quantity']
            );
        }

        //return $isCreated;
        if (!$isCreated) {
            return $listener->orderCreatedErrors(
                new MessageBag(['轉倉單開單失敗!'])
            );
        }
        return $listener->orderCreated(
            new MessageBag(['轉倉單已新增!']), $code
        );
    }

    public function update($listener, $orderMaster, $orderDetail, $code)
    {
        $isUpdated = true;

        //將庫存數量恢復到未開單前
        $this->revertStockInventory($code);
        //移除本單據的庫存出庫記錄
        $this->stockOutLogs->deleteStockOutLogsByOrderCode('stockTransfer', $code);
        //移除本單據的庫存入庫記錄
        $this->stockInLogs->deleteStockInLogsByOrderCode('stockTransfer', $code);
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
            //更新調出倉庫數量，因為是調出，所以扣掉數量
            $this->stock->incrementInventory(
                -$value['quantity'],
                $value['stock_id'],
                $orderMaster['from_warehouse_id']
            );
            //添加一筆庫存出庫記錄
            $this->stockOutLogs->addStockOutLog(
                'stockTransfer',
                $value['master_code'],
                $orderMaster['from_warehouse_id'],
                $value['stock_id'],
                -$value['quantity']
            );
            //更新調入倉庫數量，因為是調入，所以把數量加回來
            $this->stock->incrementInventory(
                $value['quantity'],
                $value['stock_id'],
                $orderMaster['to_warehouse_id']
            );
            //添加一筆庫存入庫記錄
            $this->stockInLogs->addStockInLog(
                'stockTransfer',
                $value['master_code'],
                $orderMaster['to_warehouse_id'],
                $value['stock_id'],
                $value['quantity']
            );
        }

        //return $isUpdated;
        if (!$isUpdated) {
            return $listener->orderUpdatedErrors(
                new MessageBag(['轉倉單更新失敗!'])
            );
        }
        return $listener->orderUpdated(
            new MessageBag(['轉倉單已更新!']), $code
        );
    }

    public function delete($listener, $code)
    {
        $isDeleted = true;

        //將庫存數量恢復到未開單前
        $this->revertStockInventory($code);
        //移除本單據的庫存出庫記錄
        $this->stockOutLogs->deleteStockOutLogsByOrderCode('stockTransfer', $code);
        //移除本單據的庫存入庫記錄
        $this->stockInLogs->deleteStockInLogsByOrderCode('stockTransfer', $code);
        //將這張單作廢
        $isDeleted = $isDeleted && $this->orderRepository->deleteOrderMaster($code);
        //$this->orderRepository->deleteOrderDetail($code);

        if (!$isDeleted) {
            return $listener->orderDeletedErrors(
                new MessageBag(['轉倉單刪除失敗!'])
            );
        }
        return $listener->orderDeleted(
            new MessageBag(['轉倉單已刪除!']), $code
        );
    }

    public function revertStockInventory($code) {
        //將庫存數量恢復到未開單前
        $old_OrderMaster = $this->orderRepository->getOrderMaster($code);
        $old_OrderDetail = $this->orderRepository->getOrderDetail($code);
        foreach ($old_OrderDetail as $key => $value) {
            //回復調出倉庫數量，因為是調出，所以把數量加回來
            $this->stock->incrementInventory(
                $value['quantity'],
                $value['stock_id'],
                $old_OrderMaster['from_warehouse_id']
            );
            //更新調入倉庫數量，因為是調入，所以把數量扣掉
            $this->stock->incrementInventory(
                -$value['quantity'],
                $value['stock_id'],
                $old_OrderMaster['to_warehouse_id']
            );
        }
    }
}