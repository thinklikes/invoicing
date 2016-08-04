<?php
namespace BillOfSale;

use BillOfSale\BillOfSaleRepository as Order;
use Stock\StockWarehouseRepository as StockWarehouse;
use StockOutLogs\StockOutLogsRepository as StockOutLogs;
use Illuminate\Support\MessageBag;
use App\Libaries\OrderCalculator;

class BillOfSaleService
{
    protected $order, $calculator, $stockOutLogs;
    protected $stock;
    private $masterInputName = 'billOfSaleMaster';
    private $detailInputName = 'billOfSaleDetail';
    private $routeName = 'erp.sale.billOfSale';

    public function __construct(
        Order $order,
        StockWarehouse $stock,
        OrderCalculator $calculator,
        StockOutLogs $stockOutLogs
    ) {
        $this->order        = $order;
        $this->stock        = $stock;
        $this->calculator   = $calculator;
        $this->stockOutLogs = $stockOutLogs;
    }

    /**
     * 攔截輸入過的表單建立資料以顯示
     * @param  Request $request 請求的資料
     * @return array
     */
    public function getCreateDataBeforeShown($master, $details)
    {
        if (count($master) > 0) {
            //資料輸入計算機並且開始計算
            $this->calculator->setValuesAndCalculate([
                'quantity'     => array_pluck($details, 'quantity'),
                'no_tax_price' => array_pluck($details, 'no_tax_price'),
                'discount'     => array_pluck($details, 'discount'),
                'discount_enabled' => true,
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
            $this->masterInputName => $master,
            $this->detailInputName => $details,
        ];
    }

    public function create($listener, $master, $details)
    {

        $isCreated = true;
        $code = $this->order->getNewOrderCode();
        $master['code'] = $code;

        //資料輸入計算機並且開始計算
        $this->calculator->setValuesAndCalculate([
            'quantity'     => array_pluck($details, 'quantity'),
            'no_tax_price' => array_pluck($details, 'no_tax_price'),
            'discount'     => array_pluck($details, 'discount'),
            'discount_enabled' => true,
        ]);

        $master['total_amount'] = $this->calculator->getTotalAmount();
        //新增銷貨單表頭
        $isCreated = $isCreated && $this->order->storeOrderMaster($master);

        //新增銷貨單表身
        foreach($details as $key => $value) {
            if ($value['quantity'] == 0 || $value['quantity'] == "") {
                continue;
            }
            $value['master_code'] = $code;
            //存入表身
            $isCreated = $isCreated && $this->order
                ->storeOrderDetail($value);
            //更新倉庫數量，因為是銷貨，扣掉數量
            $this->stock->incrementInventory(
                -$value['quantity'],
                $value['stock_id'],
                $master['warehouse_id']
            );
            //添加一筆庫存出庫記錄
            $this->stockOutLogs->addStockOutLog(
                'billOfSale',
                $value['master_code'],
                $master['warehouse_id'],
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

    public function update($listener, $master, $details, $code)
    {
        $isUpdated = true;

        //將庫存數量恢復到未開單前
        $this->revertStockInventory($code);
        //移除本單據的庫存出庫記錄
        $this->stockOutLogs->deleteStockOutLogsByOrderCode('billOfSale', $code);

        $this->calculator->setOrderMaster($master);
        $this->calculator->setOrderDetail($details);
        $this->calculator->calculate();

        $master['total_amount'] = $this->calculator->getTotalAmount();
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
            //更新數量
            $this->stock->incrementInventory(
                -$value['quantity'],
                $value['stock_id'],
                $master['warehouse_id']
            );
            //添加一筆庫存出庫記錄
            $this->stockOutLogs->addStockOutLog(
                'billOfSale',
                $value['master_code'],
                $master['warehouse_id'],
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
        $isDeleted = $isDeleted && $this->order->deleteOrderMaster($code);
        //$this->order->deleteOrderDetail($code);

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
        $old_OrderMaster = $this->order->getOrderMaster($code);
        $old_OrderDetail = $this->order->getOrderDetail($code);
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