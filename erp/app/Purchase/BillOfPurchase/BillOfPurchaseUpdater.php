<?php
namespace App\Purchase\BillOfPurchase;

//use App\Purchase\BillOfPurchaseRepository;
use App\Repositories\StockWarehouseRepository;
use Illuminate\Support\MessageBag;

class BillOfPurchaseUpdater
{
    protected $orderRepository;
    protected $stock;

    public function __construct(
        BillOfPurchaseRepository $orderRepository,
        StockWarehouseRepository $stock
    ) {
        $this->orderRepository = $orderRepository;
        $this->stock           = $stock;
    }

    public function update($listener, $orderMaster, $orderDetail)
    {
        $isUpdated = true;

        $code = $orderMaster['code'];

        //將庫存數量恢復到未開單前
        $listener->retrunStockInventory($code);

        //先存入表頭
        $isUpdated = $isUpdated && $this->orderRepository->updateOrderMaster(
            $orderMaster, $code
        );
        //dd($isUpdated);
        //清空表身
        $isUpdated = $isUpdated && $this->orderRepository->deleteOrderDetail($code);

        foreach ($orderDetail as $key => $value) {
            if ($value['quantity'] == 0 || $value['quantity'] == "") {
                continue;
            }
            //存入表身
            $isUpdated = $isUpdated && $this->orderRepository->updateOrderDetail(
                $value, $code
            );
            //更新數量
            $this->stock->updateInventory(
                $value['quantity'],
                $value['stock_id'],
                $orderMaster['warehouse_id']
            );
        }

        if (!$isUpdated) {
            return $listener->orderUpdatedErrors(
                new MessageBag(['進貨單更新失敗!'])
            );
        }
        return $listener->orderUpdated(
            new MessageBag(['進貨單已更新!']), $code
        );
    }
}