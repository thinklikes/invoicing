<?php
namespace App\Services\Purchase;

use App\Repositories\Purchase\PayableWriteOffRepository as OrderRepository;
use App\Repositories\Purchase\PaymentRepository as Payment;
use App\Repositories\Purchase\BillOfPurchaseRepository as BillOfPurchase;
use App\Repositories\Purchase\ReturnOfPurchaseRepository as ReturnOfPurchase;
use Illuminate\Support\MessageBag;

class PayableWriteOffService
{
    protected $orderRepository;
    protected $payment;
    protected $billOfPurchase;
    protected $returnOfPurchase;

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
            //更新應付帳款沖銷單為已沖銷
            switch ($value['debit_type']) {
                case 'billsOfPurchase':
                    $this->billOfPurchase->updatePaidAmount($value['debit_amount'], $code);
                    //找出未付清的款項
                    $not_paid_amount = $this->billOfPurchase->getNotPaidAmount($code);
                    //判斷未付清款項是否為0，
                    //若是設定這張單為已付清
                    if ($not_paid_amount == 0) {
                        $this->billOfPurchase->setIsPaid(1, $code);
                    }
                    break;

                case 'returnsOfPurchase':
                    //因為資料庫是記錄正數，把負數金額轉回正數再更新
                    $this->returnOfPurchase->updatePaidAmount(-$value['debit_amount'], $code);
                    //找出未付清的款項
                    $not_paid_amount = $this->returnOfPurchase->getNotPaidAmount($code);
                    if ($not_paid_amount == 0) {
                        $this->returnOfPurchase->setIsPaid(1, $code);
                    }

                    break;
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
                new MessageBag(['應付帳款沖銷單更新失敗!'])
            );
        }
        return $listener->orderUpdated(
            new MessageBag(['應付帳款沖銷單已更新!']), $code
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
                new MessageBag(['應付帳款沖銷單刪除失敗!'])
            );
        }
        return $listener->orderDeleted(
            new MessageBag(['應付帳款沖銷單已刪除!']), $code
        );
    }
}