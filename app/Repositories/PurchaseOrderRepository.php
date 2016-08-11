<?php

namespace App\Repositories;

use App\PurchaseOrderMaster;

use App\PurchaseOrderDetail;

use DB;

use Schema;

class PurchaseOrderRepository
{
    protected $purchaseOrderMaster;
    protected $purchaseOrderDetail;

    /**
     * PurchaseOrderRepository constructor.
     *
     * @param PurchaseOrderMaster $puchase_order_master
     */
    public function __construct(PurchaseOrderMaster $purchaseOrderMaster, PurchaseOrderDetail $purchaseOrderDetail)
    {
        $this->purchaseOrderMaster = $purchaseOrderMaster;
        $this->purchaseOrderDetail = $purchaseOrderDetail;
    }

    /**
     * [getTableColumnList get table all columns]
     * @param  Eloquent $obj 表頭或表身的Eloquent
     * @return array      all columns
     */
    public function getTableColumnList($obj)
    {
        return Schema::getColumnListing($obj->getTable());
        //return $this->purchaseOrderMaster->getTable();
    }
/**
 * [getNewMasterCode 回傳新一組的表頭CODE]
 *
 * @return string      newMasterCode
 */
    public function getNewMasterCode()
    {
        $code = $this->purchaseOrderMaster->select('code')
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
     * find all purchases
     * @return array all purchases
     */
    public function getAllPurchasesId()
    {
        // $purchases = Purchase::select('id')
        //     ->get()
        //     ->toArray();
        // //array_flatten() => 將多維的陣列轉成一維陣列
        // $purchases = array_flatten($purchases);
        // return $purchases;
    }

    /**
     * find all pair purchases = id:fullcomment
     * @return array all purchases
     */
    public function getAllPurchasesPair()
    {
        // $purchases = Purchase::select(
        //         DB::raw('concat(code, " ",comment) as full_comment, id')
        //     )
        //     ->lists('full_comment', 'id');
        // return $purchases;
    }
    /**
     * find a page of purchases
     * @return array all purchases
     */
    public function getPurchaseOrdersOnePage()
    {
        return $this->purchaseOrderMaster->paginate(15);
    }
    /**
     * find detail of one purchase order
     * @param  integer $id The id of purchase
     * @return array       one purchase
     */
    public function getPurchaseOrderDetail($code)
    {
        $purchase_order = array();
        $purchase_order['master'] = $this->purchaseOrderMaster->with(['supplier' =>
            function ($query) {
                $query->select('code', 'name');
            }])
            ->where('code', $code)
            ->firstOrFail();

        $purchase_order['detail'] = $this->purchaseOrderDetail->where('master_code', $code)
            ->with(['stock' => function ($query) {
                $query->select('id', 'code', 'name', 'unit_id');
            }])
            ->get();
            // var_dump(DB::getQueryLog());
            // dd($purchase_order['detail']);
        return $purchase_order;
    }

    /**
     * store a purchase order
     * @param  integer $id The id of purchase
     * @return void
     */
    public function storePurchaseOrder($purchase_order)
    {
        //找出表頭資料表所有的欄位
        $columns = $this->getTableColumnList($this->purchaseOrderMaster);

        $this->purchaseOrderMaster = new PurchaseOrderMaster;

        //有這個欄位才存入
        foreach($columns as $key) {
            if (isset($purchase_order['master'][$key])) {
                $this->purchaseOrderMaster->{$key} = $purchase_order['master'][$key];
            }
        }

        //開始存入表頭
        $this->purchaseOrderMaster->save();

        $columns = $this->getTableColumnList($this->purchaseOrderDetail);
        //dd($purchase_order['detail']);
        foreach($purchase_order['detail'] as $key => $value) {
            if ($value['quantity'] == 0 || $value['quantity'] == "") {
                continue;
            }

            $this->purchaseOrderDetail = new PurchaseOrderDetail;
            $this->purchaseOrderDetail->master_code  = $this->purchaseOrderMaster->code;
            foreach ($columns as $key2) {
                if (isset($value[$key2])) {
                    $this->purchaseOrderDetail->{$key2} = $value[$key2];
                }
            }
            $this->purchaseOrderDetail->save();
        }

        return $this->purchaseOrderMaster->code;
    }

    /**
     * update a Purchase
     * @param  integer $id The id of purchase
     * @return void
     */
    public function updatePurchaseOrder($purchase_order, $code)
    {
        //找出表頭資料表所有的欄位
        $columns = $this->getTableColumnList($this->purchaseOrderMaster);

        $this->purchaseOrderMaster = $this->purchaseOrderMaster
            ->where('code', $code)
            ->first();

        //有這個欄位才存入
        foreach($columns as $key) {
            if (isset($purchase_order['master'][$key])) {
                $this->purchaseOrderMaster->{$key} = $purchase_order['master'][$key];
            }
        }

        //開始存入表頭
        $this->purchaseOrderMaster->save();

        $columns = $this->getTableColumnList($this->purchaseOrderDetail);
        //dd($purchase_order['detail']);
        //清掉舊資料
        $this->purchaseOrderDetail->where('master_code', $code)->delete();

        foreach($purchase_order['detail'] as $key => $value) {
            if ($value['quantity'] == 0 || $value['quantity'] == "") {
                continue;
            }

            $this->purchaseOrderDetail = new PurchaseOrderDetail;
            $this->purchaseOrderDetail->master_code  = $this->purchaseOrderMaster->code;
            foreach ($columns as $key2) {
                if (isset($value[$key2])) {
                    $this->purchaseOrderDetail->{$key2} = $value[$key2];
                }
            }
            $this->purchaseOrderDetail->save();
        }

        return $this->purchaseOrderMaster->code;
    }

    /**
     * delete a Purchase
     * @param  integer $id The id of purchase
     * @return void
     */
    public function deletePurchaseOrder($code)
    {

        $this->purchaseOrderMaster->where('code', $code)
            ->delete();
    }
}