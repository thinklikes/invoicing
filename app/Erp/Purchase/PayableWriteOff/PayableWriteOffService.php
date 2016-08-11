<?php
namespace PayableWriteOff;

use PayableWriteOff\PayableWriteOffRepository as OrderRepository;
use Payment\PaymentRepository as Payment;
use BillOfPurchase\BillOfPurchaseRepository as BillOfPurchase;
use ReturnOfPurchase\ReturnOfPurchaseRepository as ReturnOfPurchase;
use Illuminate\Support\MessageBag;

class PayableWriteOffService
{
    private $orderRepository;
    private $payment;
    private $billOfPurchase;
    private $returnOfPurchase;
    private $debitPositive = ['billOfPurchase' => 1, 'returnOfPurchase' => -1];

    public function __construct(
        OrderRepository $orderRepository,
        Payment $payment,
        BillOfPurchase $billOfPurchase,
        ReturnOfPurchase $returnOfPurchase
    ) {
        $this->orderRepository = $orderRepository;
        $this->payment = $payment;
        $this->billOfPurchase = $billOfPurchase;
        $this->returnOfPurchase = $returnOfPurchase;
    }

    public function create($listener, $orderMaster, $orderCredit, $orderDebit)
    {
        $isCreated = true;

        $code = $this->orderRepository->getNewOrderCode();

        $orderMaster['code'] = $code;
        //新增應付帳款沖銷單表頭
        $isCreated = $isCreated && $this->orderRepository->storeOrderMaster($orderMaster);
        //新增應付帳款沖銷單貸方項目
        foreach($orderCredit as $key => $value) {
            if (!isset($value['credit_checked'])) {
                continue;
            }

            $value['master_code'] = $code;
            //存入表身
            $isCreated = $isCreated && $this->orderRepository
                ->storeOrderCredit($value);
            $this->payment->setIsWrittenOff(1, $value['credit_code']);
        }

        //新增應付帳款沖銷單借方項目
        foreach($orderDebit as $key => $value) {
            if (!isset($value['debit_checked'])) {
                continue;
            }

            $value['master_code'] = $code;
            //存入表身
            $isCreated = $isCreated && $this->orderRepository
                ->storeOrderDebit($value);
            //更新應付帳款
            $this->{$value['debit_type']}->incrementPaidAmount(
                $value['debit_amount'] * $this->debitPositive[$value['debit_type']],
                $value['debit_code']
            );
            //找出未付清的款項
            $not_paid_amount = $this->{$value['debit_type']}->getNotPaidAmount($value['debit_code']);
            //判斷未付清款項是否為0，
            //若是則設定這張單為已付清
            if ($not_paid_amount == 0) {
                $this->{$value['debit_type']}->setIsPaid(1, $value['debit_code']);
            }
        }

        //return $isCreated;
        if (!$isCreated) {
            return $listener->orderCreatedErrors(
                new MessageBag(['應付帳款沖銷單開單失敗!'])
            );
        }
        return $listener->orderCreated(
            new MessageBag(['應付帳款沖銷單已新增!']), $code
        );
    }

    public function delete($listener, $code)
    {
        $isDeleted = true;
        //恢復付款單狀態到未開單前
        $this->orderRepository->getOrderCredit($code)->each(function ($item, $key) {
            $this->payment->setIsWrittenOff(0, $item['credit_code']);
        });

        //恢復應付帳款狀態到未開單前
        $this->orderRepository->getOrderDebit($code)->each(function ($item, $key) {
            //更新應付帳款
            $this->{$item['debit_type']}->incrementPaidAmount(
                -1 * $item['debit_amount'] * $this->debitPositive[$item['debit_type']],
                $item['debit_code']
            );
            //找出未付清的款項
            $not_paid_amount = $this->{$item['debit_type']}
                ->getNotPaidAmount($item['debit_code']);
            //判斷未付清款項是否大於0，
            //若是則設定這張單為未付清
            if ($not_paid_amount > 0) {
                $this->{$item['debit_type']}->setIsPaid(0, $item['debit_code']);
            }
        });
        //將這張單作廢
        $isDeleted = $isDeleted && $this->orderRepository->deleteOrderMaster($code);
        //$this->orderRepository->deleteOrderDetail($code);

        if (!$isDeleted) {
            return $listener->orderDeletedErrors(
                new MessageBag(['應付帳款沖銷單刪除失敗!'])
            );
        }
        return $listener->orderDeleted(
            new MessageBag(['應付帳款沖銷單已刪除!']), $code
        );
    }
}