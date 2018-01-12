<?php

namespace BillOfSale;

use App;
use App\Repositories\BasicRepository;
use BillOfSale\BillOfSaleMaster as OrderMaster;
use BillOfSale\BillOfSaleDetail as OrderDetail;
use DB;

class BillOfSaleRepository extends BasicRepository
{
    protected $orderDetail;
    /**
     * BillOfSaleRepository constructor.
     *
     * @param BillOfSaleMaster $puchase_order_master
     */
    public function __construct(
        OrderMaster $orderMaster, OrderDetail $orderDetail)
    {
        $this->mainModel = $orderMaster;//$OrderMaster;
        $this->orderDetail = $orderDetail;
    }

    /**
     * find master of a order
     * @param  integer $id The id of purchase
     * @return array       one purchase
     */
    public function getOrderMaster($code)
    {
        return $this->mainModel->with('company', 'warehouse')
            ->where('code', $code)->firstOrFail();
    }

    /**
     * find detail of one purchase order
     * @param  integer $id The id of purchase
     * @return array       one purchase
     */
    public function getOrderDetail($code)
    {
        return $this->orderDetail->with('stock')->where('master_code', $code)->get();
    }

    /**
     * store billOfSaleMaster
     * @param  Array billOfSaleMaster
     * @return boolean
     */
    public function storeOrderMaster($orderMaster)
    {
        $columnsOfMaster = $this->getTableColumnList($this->mainModel);
        $this->mainModel = App::make(OrderMaster::class);
        //判斷request傳來的欄位是否存在，有才存入此欄位數值
        foreach($columnsOfMaster as $key) {
            if (isset($orderMaster[$key])) {
                $this->mainModel->{$key} = $orderMaster[$key];
            }
        }

        //開始存入表頭
        return $this->mainModel->save();
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
        $columnsOfMaster = $this->getTableColumnList($this->mainModel);

        $this->mainModel = $this->mainModel
            ->where('code', $code)
            ->first();

        //有這個欄位才存入
        foreach($columnsOfMaster as $key) {
            if (isset($orderMaster[$key])) {
                $this->mainModel->{$key} = $orderMaster[$key];
            }
        }
        $this->mainModel->code = $code;
        //開始存入表頭
        return $this->mainModel->save();
    }

    /**
     * 遞增已收款項
     * @param  integer $received_amount 本次收款金額
     * @param  string $code        銷貨單號
     * @return boolean             是否更新成功
     */
    public function incrementReceivedAmount($amount, $code)
    {
        return $this->mainModel->where('code', $code)
            ->increment('received_amount', $amount);
    }

    /**
     * 更新是否已收款
     * @param  integer $is_received 是否已收款 1:已收款, 0:未收款
     * @param  string $code        銷貨單號
     * @return boolean             是否更新成功
     */
    public function setIsReceived($is_received, $code)
    {
        return $this->mainModel->where('code', $code)
            ->update(['is_received' => $is_received]);
    }

    /**
     * delete a Purchase
     * @param  integer $id The id of purchase
     * @return void
     */
    public function deleteOrderMaster($code)
    {
        return $this->mainModel
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

    /**
     * 找出輸入的客戶id的銷貨記錄
     * @param  integer $company_id 客戶的id
     * @param  integer $stock_id   料品的id
     * @param  date $start_date 資料範圍的起始日期
     * @param  date $end_date   資料範圍的終止日期
     * @return BillOfSaleMaster
     */
    public function getFullOrderDetailByConditions(
        $company_id = '', $stock_id = '', $start_date = '', $end_date = '')
    {
        return $this->mainModel
            ->with(['orderDetail' => function ($query) use ($stock_id) {
                if ($stock_id != '') {
                    $query->where('stock_id', '=', $stock_id);
                }
            }])
            ->whereHas('orderDetail', function ($query) use ($stock_id) {
                //找看看銷貨單是否符合下列條件
                if ($stock_id != '') {
                    $query->where('stock_id', '=', $stock_id);
                }
            })
            ->Where(function ($query) use ($company_id, $start_date, $end_date) {
                if ($company_id != '') {
                    $query->where('company_id', '=', $company_id);
                }
                if ($start_date != '') {
                    $query->where('date', '>=', $start_date);
                }
                if ($start_date != '') {
                    $query->where('date', '<=', $end_date);
                }
            })
            ->orderBy('code')
            ->get();
    }

    /**
     * 找出輸入的客戶id未收款的所有應收帳款
     * @return array all companys
     */
    public function getReceivableByCompanyId(
        $company_id = '', $start_date = '', $end_date = '')
    {
        return $this->mainModel
            ->select('id', 'code', 'tax_rate_code', 'invoice_code',
                'total_amount', 'received_amount', 'date', 'company_id')
            ->Where(function ($query) use ($company_id, $start_date, $end_date) {
                if ($company_id != '') {
                    $query->where('company_id', '=', $company_id);
                }
                if ($start_date != '') {
                    $query->where('date', '>=', $start_date);
                }
                if ($start_date != '') {
                    $query->where('date', '<=', $end_date);
                }
            })
            ->where('is_received', '0')
            ->orderBy('code')
            ->get();
    }

    public function getReceivableData($param = [])
    {
        return $this->mainModel
            ->select('id', 'code', 'tax_rate_code', 'invoice_code',
                'total_amount', 'received_amount', 'date', 'company_id')
            ->Where(function ($query) use ($param) {
                if (count($param) > 0) {
                    foreach ($param as $key => $value) {
                        $query->where($key, '=', $value);
                    }
                }
            })
            ->where('is_received', '0')
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
        $code = $this->mainModel->select('code')
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
    public function getOrdersPaginated($count)
    {
        return $this->mainModel->orderBy('id', 'desc')->paginate($count);
    }

    public function getOrderMasterfield($field, $code)
    {
        return $this->mainModel->where('code', $code)->value($field);
    }

    public function getNotReceivedAmount($code)
    {
        return $this->mainModel->select(DB::raw('(total_amount - received_amount) as not_received_amount'))
            ->where('code', $code)->value('not_received_amount');
    }

    /**
     * 檢查電商平台上傳的內容，其中的訂單號是否有存在
     * @param  arrray $dataRow 電商平台文件中的一個excel row
     * @return boolean 是否已有這個客戶
     */
    public function checkBillExistsForB2C($dataRow)
    {
        $bill = $this->mainModel->where('customerOrderCode', '=', $dataRow['customerOrderCode'])
            ->first();

        return $bill ? $bill : false;
    }
}