<?php

namespace App\Purchase\BillOfPurchase;

//use App\Purchase\BillOfPurchaseMaster;

//use App\Purchase\BillOfPurchaseDetail;

use DB;

use Schema;

class BillOfPurchaseRepository
{
    protected $OrderMaster;
    protected $OrderDetail;

    protected $orderMasterClassName = BillOfPurchaseMaster::class;
    protected $orderDetailClassName = BillOfPurchaseDetail::class;
    /**
     * BillOfPurchaseRepository constructor.
     *
     * @param BillOfPurchaseMaster $puchase_order_master
     */
    public function __construct(
        BillOfPurchaseMaster $OrderMaster,
        BillOfPurchaseDetail $OrderDetail)
    {
        $this->OrderMaster = $OrderMaster;
        $this->OrderDetail = $OrderDetail;
    }

    /**
     * [getTableColumnList get table all columns]
     * @param  Eloquent $obj 表頭或表身的Eloquent
     * @return array      all columns
     */
    private function getTableColumnList($obj)
    {
        return Schema::getColumnListing($obj->getTable());
        //return $this->OrderMaster->getTable();
    }
/**
 * [getNewMasterCode 回傳新一組的表頭CODE]
 *
 * @return string      newMasterCode
 */
    public function getNewOrderCode()
    {
        $code = $this->OrderMaster->select('code')
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
        return $this->OrderMaster->orderBy('id', 'desc')->paginate($ordersPerPage);
    }

    /**
     * find master of a order
     * @param  integer $id The id of purchase
     * @return array       one purchase
     */
    public function getOrderMaster($code)
    {
        $array = $this->OrderMaster
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
        $array = $this->OrderDetail
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
        $columnsOfMaster = $this->getTableColumnList($this->OrderMaster);

        $this->OrderMaster = new $this->orderMasterClassName;
        //判斷request傳來的欄位是否存在，有才存入此欄位數值
        foreach($columnsOfMaster as $key) {
            if (isset($orderMaster[$key])) {
                $this->OrderMaster->{$key} = $orderMaster[$key];
            }
        }

        //開始存入表頭
        return $this->OrderMaster->save();
    }

    /**
     * store a purchase order
     * @param  integer $id The id of purchase
     * @return void
     */
    public function storeOrderDetail($orderDetail, $code)
    {
        $columnsOfDetail = $this->getTableColumnList($this->OrderDetail);

        $this->OrderDetail = new $this->OrderDetail;
        $this->OrderDetail->master_code  = $code;
        //dd($orderDetail);
        foreach ($columnsOfDetail as $key) {
            //echo $key."<br>";
            if (isset($orderDetail[$key])) {
                $this->OrderDetail->{$key} = $orderDetail[$key];
            }
        }
        //var_dump($orderDetail);
        //dd($this->OrderDetail);
        return $this->OrderDetail->save();
    }

    /**
     * update billOfPurchaseMaster
     * @param  integer $id The id of purchase
     * @return void
     */
    public function updateOrderMaster($orderMaster, $code)
    {
        $columnsOfMaster = $this->getTableColumnList($this->OrderMaster);

        $this->OrderMaster = $this->OrderMaster
            ->where('code', $code)
            ->first();

        //有這個欄位才存入
        foreach($columnsOfMaster as $key) {
            if (isset($orderMaster[$key])) {
                $this->OrderMaster->{$key} = $orderMaster[$key];
            }
        }
        //開始存入表頭
        $this->OrderMaster->save();
    }
    /**
     * update a Purchase
     * @param  integer $id The id of purchase
     * @return void
     */
    public function updateOrderDetail($orderDetail, $code)
    {
        $columnsOfDetail = $this->getTableColumnList($this->OrderDetail);

        $this->OrderDetail = new BillOfPurchaseDetail;
        $this->OrderDetail->master_code  = $this->OrderMaster->code;
        foreach ($columnsOfDetail as $key2) {
            if (isset($orderDetail[$key2])) {
                $this->OrderDetail->{$key2} = $orderDetail[$key2];
            }
        }
        return $this->OrderDetail->save();
    }

    /**
     * delete a Purchase
     * @param  integer $id The id of purchase
     * @return void
     */
    public function deleteOrderMaster($code)
    {

        return $this->OrderMaster
            ->where('code', $code)
            ->delete();
    }

    public function deleteOrderDetail($code)
    {
        return $this->OrderDetail
            ->where('master_code', $code)
            ->delete();
    }
}