<?php
namespace App\Purchase\BillOfPurchase;

//use App\Purchase\BillOfPurchaseRepository;
use App\Repositories\StockWarehouseRepository;
use Illuminate\Support\MessageBag;

class BillOfPurchaseCreator
{
    protected $OrderRepository;
    protected $stockWarehouseRepository;

    public function __construct(
        BillOfPurchaseRepository $OrderRepository,
        StockWarehouseRepository $stockWarehouseRepository
    ) {
        $this->OrderRepository          = $OrderRepository;
        $this->stockWarehouseRepository = $stockWarehouseRepository;
    }

    public function create($listener, $orderMaster, $orderDetail)
    {
        $isCreated = true;

        $code = $orderMaster['code'];

        //新增進貨單表頭
        $isCreated = $isCreated && $this->OrderRepository->storeOrderMaster($orderMaster);

        //新增進貨單表身
        foreach($orderDetail as $key => $value) {
            if ($value['quantity'] == 0 || $value['quantity'] == "") {
                continue;
            }
            //存入表身
            $isCreated = $isCreated && $this->OrderRepository->storeOrderDetail(
                $value, $code
            );
            //更新倉庫數量
            $this->stockWarehouseRepository->updateInventory(
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