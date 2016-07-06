<?php
namespace App\Services\Purchase;

use App\Repositories\Purchase\PaymentRepository as OrderRepository;
use Illuminate\Support\MessageBag;

class PaymentService
{
    protected $orderRepository;
    protected $stock;

    public function __construct(
        OrderRepository $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
    }

    public function create($listener, $orderMaster)
    {
        $isCreated = true;

        $code = $this->orderRepository->getNewOrderCode();

        $orderMaster['code'] = $code;
        //新增付款單表頭
        $isCreated = $isCreated && $this->orderRepository->storeOrderMaster($orderMaster);

        //return $isCreated;
        if (!$isCreated) {
            return $listener->orderCreatedErrors(
                new MessageBag(['付款單開單失敗!'])
            );
        }
        return $listener->orderCreated(
            new MessageBag(['付款單已新增!']), $code
        );
    }

    public function update($listener, $orderMaster, $code)
    {
        $isUpdated = true;

        //先存入表頭
        $isUpdated = $isUpdated && $this->orderRepository->updateOrderMaster(
            $orderMaster, $code
        );

        //return $isUpdated;
        if (!$isUpdated) {
            return $listener->orderUpdatedErrors(
                new MessageBag(['付款單更新失敗!'])
            );
        }
        return $listener->orderUpdated(
            new MessageBag(['付款單已更新!']), $code
        );
    }

    public function delete($listener, $code)
    {
        $isDeleted = true;

        //將這張單作廢
        $isDeleted = $isDeleted && $this->orderRepository->deleteOrderMaster($code);
        //$this->orderRepository->deleteOrderDetail($code);

        if (!$isDeleted) {
            return $listener->orderDeletedErrors(
                new MessageBag(['付款單刪除失敗!'])
            );
        }
        return $listener->orderDeleted(
            new MessageBag(['付款單已刪除!']), $code
        );
    }
}