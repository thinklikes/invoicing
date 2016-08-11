<?php

namespace PayableWriteOff;

use App;
use App\Repositories\BasicRepository;
use PayableWriteOff\PayableWriteOffMaster as OrderMaster;
use PayableWriteOff\PayableWriteOffCredit as OrderCredit;
use PayableWriteOff\PayableWriteOffDebit as OrderDebit;

class PayableWriteOffRepository extends BasicRepository
{
    protected $orderMaster;
    protected $orderCredit;
    protected $orderDebit;
    protected $orderMasterClassName = OrderMaster::class;
    protected $orderCreditClassName = OrderCredit::class;
    protected $orderDebitClassName = OrderDebit::class;

    /**
     * OrderRepository constructor.
     * @param App\Purchase\PayableWriteOffMaster $orderMaster 表頭資料表的model instance
     * @param App\Purchase\PayableWriteOffCredit $orderCredit 貸方項目資料表的model instance
     * @param App\Purchase\PayableWriteOffDebit  $orderDebit  借方項目資料表的model instance
     */
    public function __construct(
        OrderMaster $orderMaster,
        OrderCredit $orderCredit,
        OrderDebit $orderDebit)
    {
        $this->orderMaster = $orderMaster;
        $this->orderCredit = $orderCredit;
        $this->orderDebit = $orderDebit;
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
     * 取得表頭資料集合
     * @param  string $code 應收帳款沖銷單的單號
     * @return App\Purchase\PayableWriteOffMaster       回傳表頭資料集合
     */
    public function getOrderMaster($code)
    {
        return $this->orderMaster->where('code', $code)->firstOrFail();
    }

    /**
     * 取得貸方項目資料的集合
     * @param  string $code 應收帳款沖銷單的單號
     * @return Illuminate\Support\Collection       回傳貸方項目資料的集合
     */
    public function getOrderCredit($code)
    {
        return $this->orderCredit->where('master_code', $code)->get();
    }

    /**
     * 取得借方方項目資料的集合
     * @param  string $code 應收帳款沖銷單的單號
     * @return Illuminate\Support\Collection       回傳借方項目資料的集合
     */
    public function getOrderDebit($code)
    {
        return $this->orderDebit->where('master_code', $code)->get();
    }

    /**
     * 存入表頭資料
     * @param  Array $orderMaster 表頭資料的陣列
     * @return boolean              存入是否成功
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
     * 存入貸方項目資料
     * @param  Array $orderCredit 貸方項目的資料
     * @return boolean              存入是否成功
     */
    public function storeOrderCredit($orderCredit)
    {
        //抓出貸方資料表所有欄位
        $columnsOfCredit = $this->getTableColumnList($this->orderCredit);
        //建立一個貸方項目的model實例
        $this->orderCredit = App::make($this->orderCreditClassName);
        //判斷request傳來的欄位是否存在，有才存入此欄位數值
        foreach($columnsOfCredit as $key) {
            if (isset($orderCredit[$key])) {
                $this->orderCredit->{$key} = $orderCredit[$key];
            }
        }

        //開始存入
        return $this->orderCredit->save();
    }

    /**
     * 存入借方方項目資料
     * @param  Array $orderCredit 借方項目資料
     * @return boolean              存入是否成功
     */
    public function storeOrderDebit($orderDebit)
    {
        //抓出貸方資料表所有欄位
        $columnsOfDebit = $this->getTableColumnList($this->orderDebit);
        //建立一個貸方項目的model實例
        $this->orderDebit = App::make($this->orderDebitClassName);
        //判斷request傳來的欄位是否存在，有才存入此欄位數值
        foreach($columnsOfDebit as $key) {
            if (isset($orderDebit[$key])) {
                $this->orderDebit->{$key} = $orderDebit[$key];
            }
        }

        //開始存入
        return $this->orderDebit->save();
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