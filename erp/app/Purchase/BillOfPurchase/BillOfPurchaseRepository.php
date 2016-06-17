<?php

namespace App\Purchase\BillOfPurchase;

use App\Purchase\BillOfPurchase\BillOfPurchaseMaster as OrderMaster;
use App\Purchase\BillOfPurchase\BillOfPurchaseDetail as OrderDetail;

use DB;

use Schema;

class BillOfPurchaseRepository
{
    protected $orderMaster;
    protected $orderDetail;

    protected $orderMasterClassName = BillOfPurchaseMaster::class;
    protected $orderDetailClassName = BillOfPurchaseDetail::class;
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
     * [getTableColumnList get table all columns]
     * @param  Eloquent $obj 表頭或表身的Eloquent
     * @return array      all columns
     */
    private function getTableColumnList($obj)
    {
        return Schema::getColumnListing($obj->getTable());
        //return $this->orderMaster->getTable();
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
    public function getOrdersOnePage($ordersPerPage)
    {
        return $this->orderMaster->orderBy('id', 'desc')->paginate($ordersPerPage);
    }

    /**
     * find master of a order
     * @param  integer $id The id of purchase
     * @return array       one purchase
     */
    public function getOrderMaster($code)
    {
        $array = $this->orderMaster
            ->with([
                'supplier' => function ($query) {
                    $query->select('id', 'code', 'name');
                }
            ])
            ->with([
                'warehouse' => function ($query) {
                    $query->select('id', 'code', 'name');
                }
            ])
            ->where('code', $code)
            ->firstOrFail();

        $array->supplier_code = $array->supplier->code;
        $array->supplier_name = $array->supplier->name;
        return $array;
    }

    /**
     * find detail of one purchase order
     * @param  integer $id The id of purchase
     * @return array       one purchase
     */
    public function getOrderDetail($code)
    {
        $array = $this->orderDetail
            ->where('master_code', $code)
            ->with([
                'stock' => function ($query) {
                    $query->select('id', 'code', 'name', 'unit_id');
                }
            ])
            ->get();
        foreach ($array as $key => $value) {
            $array[$key]->stock_code = $array[$key]->stock->code;
            $array[$key]->stock_name = $array[$key]->stock->name;
            $array[$key]->unit = $array[$key]->stock->unit->comment;
        }
        return $array;
    }

    /**
     * store billOfPurchaseMaster
     * @param  Array billOfPurchaseMaster
     * @return boolean
     */
    public function storeOrderMaster($orderMaster)
    {
        $columnsOfMaster = $this->getTableColumnList($this->orderMaster);

        $this->orderMaster = new $this->orderMasterClassName;
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
    public function storeOrderDetail($orderDetail, $code)
    {
        $columnsOfDetail = $this->getTableColumnList($this->orderDetail);

        $this->orderDetail = new $this->orderDetail;
        $this->orderDetail->master_code  = $code;
        //dd($orderDetail);
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
        //開始存入表頭
        $this->orderMaster->save();
    }
    /**
     * update a Purchase
     * @param  integer $id The id of purchase
     * @return void
     */
    public function updateOrderDetail($orderDetail, $code)
    {
        $columnsOfDetail = $this->getTableColumnList($this->orderDetail);

        $this->orderDetail = new BillOfPurchaseDetail;
        $this->orderDetail->master_code  = $this->orderMaster->code;
        foreach ($columnsOfDetail as $key2) {
            if (isset($orderDetail[$key2])) {
                $this->orderDetail->{$key2} = $orderDetail[$key2];
            }
        }
        return $this->orderDetail->save();
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
            ->delete();
    }

    public function deleteOrderDetail($code)
    {
        return $this->orderDetail
            ->where('master_code', $code)
            ->delete();
    }
}