<?php
namespace StockTransfer;

use StockTransfer\StockTransferRepository as OrderRepository;
use Stock\StockWarehouseRepository as StockWarehouse;
use StockInLogs\StockInLogsRepository as StockInLogs;
use StockOutLogs\StockOutLogsRepository as StockOutLogs;
use Illuminate\Support\MessageBag;
use App\Libaries\OrderCalculator;

class StockTransferService
{
    protected $order, $stockInLogs, $stockOutLogs;
    protected $stock, $calculator;

    public function __construct(
        OrderRepository $order,
        StockWarehouse $stock,
        OrderCalculator $calculator,
        StockInLogs $stockInLogs,
        StockOutLogs $stockOutLogs
    ) {
        $this->order        = $order;
        $this->stock        = $stock;
        $this->stockInLogs  = $stockInLogs;
        $this->stockOutLogs = $stockOutLogs;
        $this->calculator   = $calculator;
    }

   /**
     * 列出指定數量的銷貨退回單
     * @param  integer $count 數量
     * @return collection         內容是銷貨退回單的集合
     */
    public function showOrders($count = 0)
    {
        return $this->order->getOrdersPaginated($count);
    }

    /**
     * 攔截輸入過的表單建立資料加以處理
     * @param  array $master 表頭資料
     * @param  array $details 表身資料
     * @return array         處理過的資料
     */
    public function getCreateFormData($master, $details)
    {
        if (count($master) > 0) {
            //資料輸入計算機並且開始計算
            $this->calculator->setValuesAndCalculate([
                'quantity'     => array_pluck($details, 'quantity'),
                'no_tax_price' => array_pluck($details, 'no_tax_price'),
            ]);

            //把未稅金額放到陣列
            foreach($details as $key => $value) {
                $details[$key]['no_tax_amount'] = $this->calculator->getNoTaxAmount($key);
            };

            //dd($details);
            $master['total_no_tax_amount'] = $this->calculator->getTotalNoTaxAmount();
            $master['tax'] = $this->calculator->getTax();
            $master['total_amount'] = $this->calculator->getTotalAmount();
        }
        return [
            'new_master_code'  => $this->order->getNewOrderCode(),
            'master' => $master,
            'details' => $details,
        ];
    }

    /**
     * 攔截顯示詳細資料加以處理
     * @param  array $master 表頭資料
     * @param  array $details 表身資料
     * @return array         處理過的資料
     */
    public function getShowTableData($code)
    {
        $master = $this->order->getOrderMaster($code);

        $details = $this->order->getOrderDetail($code);

        //資料輸入計算機並且開始計算
        $this->calculator->setValuesAndCalculate([
            'quantity'     => $details->pluck('quantity')->all(),
            'no_tax_price' => $details->pluck('no_tax_price')->all(),
        ]);

        foreach($details as $key => $item) {
            $item->no_tax_amount = $this->calculator->getNoTaxAmount($key);
        }

        $master->total_no_tax_amount = $this->calculator->getTotalNoTaxAmount();

        $master->tax = $this->calculator->getTax();

        $master->total_amount = $this->calculator->getTotalAmount();

        return [
            'master' => $master,
            'details' => $details,
        ];
    }

    /**
     * 攔截輸入過的表單建立資料加以處理
     * @param  array $master 表頭資料
     * @param  array $details 表身資料
     * @return array         處理過的資料
     */
    public function getEditFormData($code, $master, $details)
    {
        if (!$master) {
            $master = $this->order->getOrderMaster($code);
        }

        $master['code'] = $code;

        if (!$details) {
            $details = $this->order->getOrderDetail($code);
        }

        if (gettype($details) == 'array') {
            $quantity = array_pluck($details, 'quantity');
            $no_tax_price = array_pluck($details, 'no_tax_price');
        } else {
            $quantity = $details->pluck('quantity')->all();
            $no_tax_price = $details->pluck('no_tax_price')->all();
        }

        //資料輸入計算機並且開始計算
        $this->calculator->setValuesAndCalculate([
            'quantity'     => $quantity,
            'no_tax_price' => $no_tax_price,
        ]);

        foreach ($details as $key => $value) {
            $details[$key]['stock_code'] = $details[$key]['stock_code']
                ? $details[$key]['stock_code']
                : $details[$key]['stock']->code;

            $details[$key]['stock_name'] = $details[$key]['stock_name']
                ? $details[$key]['stock_name']
                : $details[$key]['stock']->name;

            $details[$key]['unit'] = $details[$key]['unit']
                ? $details[$key]['unit']
                : $details[$key]['stock']->unit->comment;

            $details[$key]['no_tax_amount'] = $this->calculator->getNoTaxAmount($key);
        }

        $master['total_no_tax_amount'] = $this->calculator->getTotalNoTaxAmount();
        $master['tax'] = $this->calculator->getTax();
        $master['total_amount'] = $this->calculator->getTotalAmount();

        return [
            'master' => $master,
            'details' => $details,
        ];
    }

    public function create($listener, $master, $details)
    {
        $isCreated = true;
        $code = $this->order->getNewOrderCode();
        $master['code'] = $code;

        //新增轉倉單表頭
        $isCreated = $isCreated && $this->order->storeOrderMaster($master);

        //新增轉倉單表身
        foreach($details as $key => $value) {
            if ($value['quantity'] == 0 || $value['quantity'] == "") {
                continue;
            }
            $value['master_code'] = $code;
            //存入表身
            $isCreated = $isCreated && $this->order
                ->storeOrderDetail($value);
            //更新調出倉庫數量，因為是調出，所以扣掉數量
            $this->stock->incrementInventory(
                -$value['quantity'],
                $value['stock_id'],
                $master['from_warehouse_id']
            );
            //添加一筆庫存出庫記錄
            $this->stockOutLogs->addStockOutLog(
                'stockTransfer',
                $value['master_code'],
                $master['from_warehouse_id'],
                $value['stock_id'],
                -$value['quantity']
            );
            //更新調入倉庫數量，因為是調入，所以把數量加回來
            $this->stock->incrementInventory(
                $value['quantity'],
                $value['stock_id'],
                $master['to_warehouse_id']
            );
            //添加一筆庫存入庫記錄
            $this->stockInLogs->addStockInLog(
                'stockTransfer',
                $value['master_code'],
                $master['to_warehouse_id'],
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

    public function update($listener, $master, $details, $code)
    {
        $isUpdated = true;

        //將庫存數量恢復到未開單前
        $this->revertStockInventory($code);
        //移除本單據的庫存出庫記錄
        $this->stockOutLogs->deleteStockOutLogsByOrderCode('stockTransfer', $code);
        //移除本單據的庫存入庫記錄
        $this->stockInLogs->deleteStockInLogsByOrderCode('stockTransfer', $code);
        //先存入表頭
        $isUpdated = $isUpdated && $this->order->updateOrderMaster(
            $master, $code
        );
        //dd($isUpdated);
        //清空表身
        $this->order->deleteOrderDetail($code);

        foreach ($details as $key => $value) {
            if ($value['quantity'] == 0 || $value['quantity'] == "") {
                continue;
            }
            $value['master_code'] = $code;
            //存入表身
            $isUpdated = $isUpdated && $this->order->storeOrderDetail($value);
            //更新調出倉庫數量，因為是調出，所以扣掉數量
            $this->stock->incrementInventory(
                -$value['quantity'],
                $value['stock_id'],
                $master['from_warehouse_id']
            );
            //添加一筆庫存出庫記錄
            $this->stockOutLogs->addStockOutLog(
                'stockTransfer',
                $value['master_code'],
                $master['from_warehouse_id'],
                $value['stock_id'],
                -$value['quantity']
            );
            //更新調入倉庫數量，因為是調入，所以把數量加回來
            $this->stock->incrementInventory(
                $value['quantity'],
                $value['stock_id'],
                $master['to_warehouse_id']
            );
            //添加一筆庫存入庫記錄
            $this->stockInLogs->addStockInLog(
                'stockTransfer',
                $value['master_code'],
                $master['to_warehouse_id'],
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
        $isDeleted = $isDeleted && $this->order->deleteOrderMaster($code);
        //$this->order->deleteOrderDetail($code);

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
        $old_OrderMaster = $this->order->getOrderMaster($code);
        $old_OrderDetail = $this->order->getOrderDetail($code);
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