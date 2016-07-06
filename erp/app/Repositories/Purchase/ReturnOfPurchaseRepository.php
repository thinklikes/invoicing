<?php

namespace App\Repositories\Purchase;

use App;
use App\Repositories\BasicRepository;
use App\Purchase\ReturnOfPurchaseMaster as OrderMaster;
use App\Purchase\ReturnOfPurchaseDetail as OrderDetail;


class ReturnOfPurchaseRepository extends BasicRepository
{
    protected $orderMaster;
    protected $orderDetail;

    protected $orderMasterClassName = OrderMaster::class;
    protected $orderDetailClassName = OrderDetail::class;
    /**
     * BillOfPurchaseRepository constructor.
     *
     * @param BillOfPurchaseMaster $puchase_order_master
     */
    public function __construct(
        OrderMaster $orderMaster, OrderDetail $orderDetail)
    {
        $this->orderMaster = $orderMaster;//$OrderMaster;
        $this->orderDetail = $orderDetail;
    }

    /**
     * 找出輸入的供應商id未付清的所有應付帳款
     * @return array all suppliers
     */
    public function getPayableBySupplierId($suppier_id)
    {
        return $this->orderMaster->select('id', 'code', 'invoice_code','total_amount', 'paid_amount', 'created_at')
            ->where('supplier_id', $suppier_id)
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
     * store billOfPurchaseMaster
     * @param  Array billOfPurchaseMaster
     * @return boolean
     */
    public function storeOrderMaster($orderMaster)
    {
        $columnsOfMaster = $this->getTableColumnList($this->orderMaster);
        $this->orderMaster = App::make($this->orderMasterClassName);
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

        $this->orderDetail = new $this->orderDetail;
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
     * update billOfPurchaseMaster
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