<?php

namespace BillOfSale;

use App;
use App\Repositories\BasicRepository;
use BillOfSale\BillOfSaleMaster as OrderMaster;
use BillOfSale\BillOfSaleDetail as OrderDetail;
use DB;

class BillOfSaleRepository extends BasicRepository
{
    protected $orderMaster;
    protected $orderDetail;
    /**
     * BillOfSaleRepository constructor.
     *
     * @param BillOfSaleMaster $puchase_order_master
     */
    public function __construct(
        OrderMaster $orderMaster, OrderDetail $orderDetail)
    {
        $this->orderMaster = $orderMaster;//$OrderMaster;
        $this->orderDetail = $orderDetail;
    }

    /**
     * 找出輸入的客戶id未付清的所有應付帳款
     * @return array all suppliers
     */
    public function getPayableByCompanyId($suppier_id)
    {
        return $this->orderMaster->select('id', 'code', 'invoice_code','total_amount', 'paid_amount', 'created_at')
            ->where('company_id', $suppier_id)
            ->where('is_paid', '0')
            ->orderBy('code')
            ->get();
    }
    /**
     * [getNewMasterCode 回傳新一組的表頭CODE]
     *
     * @return string      newMasterCode
     */
    public function getNewOrderCode()
    {
        $code = $this->orderMaster->select('code')
            ->where('code', 'like', date('Ymd').'%')
            ->orderBy('code', 'desc')
            ->withTrashed()
            ->take(1)
            ->value('code');
        if (is_null($code)) {
            return date('Ymd').'001';
        } else {
            return $code + 1;
        }
    }

    /**
     * find a page of orders
     * @return array all purchases
     */
    public function getOrdersPaginated($ordersPerPage)
    {
        return $this->orderMaster->orderBy('id', 'desc')->paginate($ordersPerPage);
    }

    public function getOrderMasterfield($field, $code)
    {
        return $this->orderMaster->where('code', $code)->value($field);
    }

    public function getNotPaidAmount($code)
    {
        return $this->orderMaster->select(DB::raw('(total_amount - paid_amount) as not_paid_amount'))
            ->where('code', $code)->value('not_paid_amount');
    }

    /**
     * find master of a order
     * @param  integer $id The id of purchase
     * @return array       one purchase
     */
    public function getOrderMaster($code)
    {
        return $this->orderMaster->where('code', $code)->firstOrFail();
    }

    /**
     * find detail of one purchase order
     * @param  integer $id The id of purchase
     * @return array       one purchase
     */
    public function getOrderDetail($code)
    {
        return $this->orderDetail->where('master_code', $code)->get();
    }

    /**
     * store billOfSaleMaster
     * @param  Array billOfSaleMaster
     * @return boolean
     */
    public function storeOrderMaster($orderMaster)
    {
        $columnsOfMaster = $this->getTableColumnList($this->orderMaster);
        $this->orderMaster = App::make(OrderMaster::class);
        //判斷request傳來的欄位是否存在，有才存入此欄位數值
        foreach($columnsOfMaster as $key) {
            if (isset($orderMaster[$key])) {
                $this->orderMaster->{$key} = $orderMaster[$key];
            }
        }

        //開始存入表頭
        return $this->orderMaster->save();
    }

    /**
     * store a purchase order
     * @param  integer $id The id of purchase
     * @return void
     */
    public function storeOrderDetail($orderDetail)
    {
        $columnsOfDetail = $this->getTableColumnList($this->orderDetail);

        $this->orderDetail = App::make(OrderDetail::class);

        foreach ($columnsOfDetail as $key) {
            //echo $key."<br>";
            if (isset($orderDetail[$key])) {
                $this->orderDetail->{$key} = $orderDetail[$key];
            }
        }
        //var_dump($orderDetail);
        //dd($this->orderDetail);
        return $this->orderDetail->save();
    }

    /**
     * update billOfSaleMaster
     * @param  integer $id The id of purchase
     * @return void
     */
    public function updateOrderMaster($orderMaster, $code)
    {
        $columnsOfMaster = $this->getTableColumnList($this->orderMaster);

        $this->orderMaster = $this->orderMaster
            ->where('code', $code)
            ->first();

        //有這個欄位才存入
        foreach($columnsOfMaster as $key) {
            if (isset($orderMaster[$key])) {
                $this->orderMaster->{$key} = $orderMaster[$key];
            }
        }
        $this->orderMaster->code = $code;
        //開始存入表頭
        return $this->orderMaster->save();
    }

    /**
     * 遞增已付款項
     * @param  integer $paid_amount 本次付款金額
     * @param  string $code        進貨單號
     * @return boolean             是否更新成功
     */
    public function incrementPaidAmount($amount, $code)
    {
        return $this->orderMaster->where('code', $code)
            ->increment('paid_amount', $amount);
    }

    /**
     * 更新是否已付清
     * @param  integer $is_paid 是否已付清 1:已付清, 0:未付清
     * @param  string $code        進貨單號
     * @return boolean             是否更新成功
     */
    public function setIsPaid($is_paid, $code)
    {
        return $this->orderMaster->where('code', $code)
            ->update(['is_paid' => $is_paid]);
    }

    /**
     * delete a Purchase
     * @param  integer $id The id of purchase
     * @return void
     */
    public function deleteOrderMaster($code)
    {
        return $this->orderMaster
            ->where('code', $code)
            ->first()
            ->delete();
    }

    public function deleteOrderDetail($code)
    {
        return $this->orderDetail
            ->where('master_code', $code)
            ->delete();
    }
}