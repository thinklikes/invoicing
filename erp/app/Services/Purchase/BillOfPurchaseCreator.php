<?php
namespace App\Purchase\BillOfPurchase;

//use App\Purchase\BillOfPurchaseRepository;
use App\Repositories\StockWarehouseRepository;
use Illuminate\Support\MessageBag;

class BillOfPurchaseCreator
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

    public function create($listener, $orderMaster, $orderDetail)
    {
        $isCreated = true;

        $code = $orderMaster['code'];

        //新增進貨單表頭
        $isCreated = $isCreated && $this->orderRepository->storeOrderMaster($orderMaster);

        //新增進貨單表身
        foreach($orderDetail as $key => $value) {
            if ($value['quantity'] == 0 || $value['quantity'] == "") {
                continue;
            }
            //存入表身
            $isCreated = $isCreated && $this->orderRepository->storeOrderDetail(
                $value, $code
            );
            //更新倉庫數量
            $this->stock->updateInventory(
                $value['quantity'],
                $value['stock_id'],
                $orderMaster['warehouse_id']
            );
        }
        if (!$isCreated) {
            return $listener->orderCreatedErrors(
                new MessageBag(['進貨單開單失敗!'])
            );
        }
        return $listener->orderCreated(
            new MessageBag(['進貨單已新增!']), $code
        );
    }
}