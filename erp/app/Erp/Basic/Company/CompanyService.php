<?php
namespace Company;

use Company\CompanyRepository as OrderRepository;
use Illuminate\Support\MessageBag;

class CompanyService
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
        //新增客戶表頭
        $reuslt = $this->orderRepository->storeCompany($orderMaster);

        $isCreated = $isCreated && $reuslt[0];

        //return $isCreated;
        if (!$isCreated) {
            return $listener->orderCreatedErrors(
                new MessageBag(['客戶開單失敗!'])
            );
        }
        return $listener->orderCreated(
            new MessageBag(['客戶已新增!']), $reuslt[1]
        );
    }

    public function update($listener, $orderMaster, $id)
    {
        $isUpdated = true;

        //先存入表頭
        $isUpdated = $isUpdated && $this->orderRepository->updateCompany(
            $orderMaster, $id
        );

        //return $isUpdated;
        if (!$isUpdated) {
            return $listener->orderUpdatedErrors(
                new MessageBag(['客戶更新失敗!'])
            );
        }
        return $listener->orderUpdated(
            new MessageBag(['客戶已更新!']), $id
        );
    }

    public function delete($listener, $id)
    {
        $isDeleted = true;

        //將這張單作廢
        $isDeleted = $isDeleted && $this->orderRepository->deleteCompany($id);
        //$this->orderRepository->deleteOrderDetail($code);

        if (!$isDeleted) {
            return $listener->orderDeletedErrors(
                new MessageBag(['客戶刪除失敗!'])
            );
        }
        return $listener->orderDeleted(
            new MessageBag(['客戶已刪除!']), $id
        );
    }
}