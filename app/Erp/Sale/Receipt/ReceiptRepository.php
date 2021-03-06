<?php

namespace Receipt;

use App;
use App\Repositories\BasicRepository;
use Receipt\Receipt as OrderMaster;

class ReceiptRepository extends BasicRepository
{
    protected $orderMaster;
    protected $orderMasterClassName = OrderMaster::class;
    /**
     * BillOfPurchaseRepository constructor.
     *
     * @param BillOfPurchaseMaster $puchase_order_master
     */
    public function __construct(OrderMaster $orderMaster)
    {
        $this->orderMaster = $orderMaster;//$OrderMaster;
    }

    /**
     * 找出輸入的客戶id未沖銷的的所有收款
     * @return array all companys
     */
    public function getReceiptData($param = [])
    {
        return $this->orderMaster->select('id', 'code', 'receive_date', 'type', 'check_code', 'amount')
            ->where(function ($query) use ($param) {
                if (count($param) > 0) {
                    foreach ($param as $key => $value) {
                        $query->where($key, '=', $value);
                    }
                }
            })
            ->where('isWrittenOff', '0')
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
        //$this->orderMaster->code = $code;
        //開始存入表頭
        return $this->orderMaster->save();
    }

    /**
     * 設定是否沖銷的狀態
     * @param boolean $isWrittenOff 是否沖銷
     * @param string  $code 收款單號
     */
    public function setIsWrittenOff($isWrittenOff = false, $code)
    {
        $this->orderMaster->where('code', $code)
            ->update(['isWrittenOff' => $isWrittenOff]);
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
}