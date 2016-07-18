<?php
namespace ReceivableWriteOff;

use ReceivableWriteOff\ReceivableWriteOffRepository as OrderRepository;
use Receipt\ReceiptRepository as Receipt;
use BillOfSale\BillOfSaleRepository as BillOfSale;
use ReturnOfSale\ReturnOfSaleRepository as ReturnOfSale;
use Illuminate\Support\MessageBag;

class ReceivableWriteOffService
{
    private $orderRepository;
    private $receipt;
    private $billOfSale;
    private $returnOfSale;
    private $creditPositive = ['billOfSale' => 1, 'returnOfSale' => -1];

    public function __construct(
        OrderRepository $orderRepository,
        Receipt $receipt,
        BillOfSale $billOfSale,
        ReturnOfSale $returnOfSale
    ) {
        $this->orderRepository = $orderRepository;
        $this->receipt = $receipt;
        $this->billOfSale = $billOfSale;
        $this->returnOfSale = $returnOfSale;
    }

    public function create($listener, $orderMaster, $orderCredit, $orderDebit)
    {
        $isCreated = true;

        $code = $this->orderRepository->getNewOrderCode();

        $orderMaster['code'] = $code;
        //新增應收帳款沖銷單表頭
        $isCreated = $isCreated && $this->orderRepository->storeOrderMaster($orderMaster);
        //新增應收帳款沖銷單借方項目
        foreach($orderDebit as $key => $value) {
            if (!isset($value['debit_checked'])) {
                continue;
            }

            $value['master_code'] = $code;
            //存入表身
            $isCreated = $isCreated && $this->orderRepository
                ->storeOrderDebit($value);
            $this->receipt->setIsWrittenOff(1, $value['debit_code']);
        }

        //新增應收帳款沖銷單貸方項目
        foreach($orderCredit as $key => $value) {
            if (!isset($value['credit_checked'])) {
                continue;
            }

            $value['master_code'] = $code;
            //存入表身
            $isCreated = $isCreated && $this->orderRepository
                ->storeOrderCredit($value);
            //更新應收帳款
            $this->{$value['credit_type']}->incrementReceivedAmount(
                $value['credit_amount'] * $this->creditPositive[$value['credit_type']],
                $value['credit_code']
            );
            //找出未收款的款項
            $not_receiced_amount = $this->{$value['credit_type']}->getNotReceivedAmount($value['credit_code']);
            //判斷未收款款項是否為0，
            //若是則設定這張單為已收款
            if ($not_receiced_amount == 0) {
                $this->{$value['credit_type']}->setIsReceived(1, $value['credit_code']);
            }
        }

        //return $isCreated;
        if (!$isCreated) {
            return $listener->orderCreatedErrors(
                new MessageBag(['應收帳款沖銷單開單失敗!'])
            );
        }
        return $listener->orderCreated(
            new MessageBag(['應收帳款沖銷單已新增!']), $code
        );
    }

    public function delete($listener, $code)
    {
        $isDeleted = true;
        //恢復收款單狀態到未開單前
        $this->orderRepository->getOrderDebit($code)->each(function ($item, $key) {
            $this->receipt->setIsWrittenOff(0, $item['debit_code']);
        });

        //恢復應收帳款狀態到未開單前
        $this->orderRepository->getOrderCredit($code)->each(function ($item, $key) {
            //更新應收帳款
            $this->{$item['credit_type']}->incrementReceivedAmount(
                -1 * $item['credit_amount'] * $this->creditPositive[$item['credit_type']],
                $item['credit_code']
            );
            //找出未收款的款項
            $not_received_amount = $this->{$item['credit_type']}
                ->getNotReceivedAmount($item['credit_code']);
            //判斷未收款款項是否大於0，
            //若是則設定這張單為未收款
            if ($not_received_amount > 0) {
                $this->{$item['credit_type']}->setIsReceived(0, $item['credit_code']);
            }
        });
        //將這張單作廢
        $isDeleted = $isDeleted && $this->orderRepository->deleteOrderMaster($code);
        //$this->orderRepository->deleteOrderDetail($code);

        if (!$isDeleted) {
            return $listener->orderDeletedErrors(
                new MessageBag(['應收帳款沖銷單刪除失敗!'])
            );
        }
        return $listener->orderDeleted(
            new MessageBag(['應收帳款沖銷單已刪除!']), $code
        );
    }
}