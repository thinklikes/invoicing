<?php

namespace App\Repositories;

use App\BillOfPurchaseMaster;

use App\BillOfPurchaseDetail;

use DB;

use Schema;

class BillOfPurchaseRepository
{
    protected $billOfPurchaseMaster;
    protected $billOfPurchaseDetail;
    /**
     * BillOfPurchaseRepository constructor.
     *
     * @param BillOfPurchaseMaster $puchase_order_master
     */
    public function __construct(BillOfPurchaseMaster $billOfPurchaseMaster,
        BillOfPurchaseDetail $billOfPurchaseDetail)
    {
        $this->billOfPurchaseMaster = $billOfPurchaseMaster;
        $this->billOfPurchaseDetail = $billOfPurchaseDetail;
    }

    /**
     * [getTableColumnList get table all columns]
     * @param  Eloquent $obj 表頭或表身的Eloquent
     * @return array      all columns
     */
    public function getTableColumnList($obj)
    {
        return Schema::getColumnListing($obj->getTable());
        //return $this->billOfPurchaseMaster->getTable();
    }
/**
 * [getNewMasterCode 回傳新一組的表頭CODE]
 *
 * @return string      newMasterCode
 */
    public function getNewMasterCode()
    {
        $code = $this->billOfPurchaseMaster->select('code')
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
     * find a page of purchases
     * @return array all purchases
     */
    public function getBillOfPurchasesOnePage()
    {
        return $this->billOfPurchaseMaster->paginate(15);
    }
    /**
     * find detail of one purchase order
     * @param  integer $id The id of purchase
     * @return array       one purchase
     */
    public function getBillOfPurchaseDetail($code)
    {
        $billOfPurchase = array();
        $billOfPurchase['master'] = $this->billOfPurchaseMaster->with([
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

        $billOfPurchase['detail'] = $this->billOfPurchaseDetail->where('master_code', $code)
            ->with([
                'stock' => function ($query) {
                    $query->select('id', 'code', 'name', 'unit_id');
                }
            ])
            ->get();
            // var_dump(DB::getQueryLog());
            // dd($billOfPurchase['detail']);
        return $billOfPurchase;
    }

    /**
     * store billOfPurchaseMaster
     * @param  Array billOfPurchaseMaster
     * @return boolean
     */
    public function storeBillOfPurchaseMaster($billOfPurchaseMaster)
    {
        $columnsOfMaster = $this->getTableColumnList($this->billOfPurchaseMaster);

        $this->billOfPurchaseMaster = new BillOfPurchaseMaster;
        //判斷request傳來的欄位是否存在，有才存入此欄位數值
        foreach($columnsOfMaster as $key) {
            if (isset($billOfPurchaseMaster[$key])) {
                $this->billOfPurchaseMaster->{$key} = $billOfPurchaseMaster[$key];
            }
        }

        //開始存入表頭
        return $this->billOfPurchaseMaster->save();
    }

    /**
     * store a purchase order
     * @param  integer $id The id of purchase
     * @return void
     */
    public function storeBillOfPurchaseDetail($billOfPurchaseDetail, $code)
    {
        $columnsOfDetail = $this->getTableColumnList($this->billOfPurchaseDetail);

        $this->billOfPurchaseDetail = new BillOfPurchaseDetail;
        $this->billOfPurchaseDetail->master_code  = $code;
        //dd($billOfPurchaseDetail);
        foreach ($columnsOfDetail as $key) {
            //echo $key."<br>";
            if (isset($billOfPurchaseDetail[$key])) {
                $this->billOfPurchaseDetail->{$key} = $billOfPurchaseDetail[$key];
            }
        }
        //var_dump($billOfPurchaseDetail);
        //dd($this->billOfPurchaseDetail);
        return $this->billOfPurchaseDetail->save();
    }

    /**
     * update billOfPurchaseMaster
     * @param  integer $id The id of purchase
     * @return void
     */
    public function updateBillOfPurchaseMaster($billOfPurchaseMaster, $code)
    {
        $columnsOfMaster = $this->getTableColumnList($this->billOfPurchaseMaster);

        $this->billOfPurchaseMaster = $this->billOfPurchaseMaster
            ->where('code', $code)
            ->first();

        //有這個欄位才存入
        foreach($columnsOfMaster as $key) {
            if (isset($billOfPurchaseMaster[$key])) {
                $this->billOfPurchaseMaster->{$key} = $billOfPurchaseMaster[$key];
            }
        }
        //開始存入表頭
        $this->billOfPurchaseMaster->save();
    }
    /**
     * update a Purchase
     * @param  integer $id The id of purchase
     * @return void
     */
    public function updateBillOfPurchaseDetail($billOfPurchaseDetail, $code)
    {
        $columnsOfDetail = $this->getTableColumnList($this->billOfPurchaseDetail);

        $this->billOfPurchaseDetail = new BillOfPurchaseDetail;
        $this->billOfPurchaseDetail->master_code  = $this->billOfPurchaseMaster->code;
        foreach ($columnsOfDetail as $key2) {
            if (isset($billOfPurchaseDetail[$key2])) {
                $this->billOfPurchaseDetail->{$key2} = $billOfPurchaseDetail[$key2];
            }
        }
        return $this->billOfPurchaseDetail->save();
    }

    public function clearBillOfPurchaseDetail($code)
    {
        return $this->billOfPurchaseDetail->where('master_code', $code)->delete();
    }

    /**
     * delete a Purchase
     * @param  integer $id The id of purchase
     * @return void
     */
    public function deleteBillOfPurchase($code)
    {

        $this->billOfPurchaseMaster->where('code', $code)
            ->delete();
    }
}