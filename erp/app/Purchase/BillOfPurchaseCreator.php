<?php
namespace App\Purchase;

//use App\Purchase\BillOfPurchaseRepository;
use App\Repositories\StockWarehouseRepository;

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

    public function create($orderMaster, $orderDetail)
    {
        $bool = true;

        $code = $orderMaster['code'];

        //新增進貨單表頭
        $bool = $bool && $this->OrderRepository->storeOrderMaster($orderMaster);

        //新增進貨單表身
        foreach($orderDetail as $key => $value) {
            if ($value['quantity'] == 0 || $value['quantity'] == "") {
                continue;
            }
            //存入表身
            $bool = $bool && $this->OrderRepository->storeOrderDetail(
                $value, $code
            );
            //更新倉庫數量
            $this->stockWarehouseRepository->updateInventory(
                $value['quantity'],
                $value['stock_id'],
                $orderMaster['warehouse_id']
            );
        }
        return $bool;
    }
}