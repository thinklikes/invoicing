<?php
namespace App\Purchase\BillOfPurchase;

//use App\Purchase\BillOfPurchaseRepository;
use App\Repositories\StockWarehouseRepository;
use Illuminate\Support\MessageBag;

class BillOfPurchaseDeleter
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

    public function delete($listener, $code)
    {
        $isDeleted = true;

        //將庫存數量恢復到未開單前
        $listener->retrunStockInventory($code);

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
}