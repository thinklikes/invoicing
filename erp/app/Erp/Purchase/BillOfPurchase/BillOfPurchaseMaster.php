<?php

namespace BillOfPurchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillOfPurchaseMaster extends Model
{
    use SoftDeletes;

    protected $table = 'erp_bill_of_purchase_master';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 回傳這個進貨單表頭所有的庫存數量
     * @return [type] [description]
     */
    public function billOfPurchaseDetail()
    {
        return $this->hasMany('Purchase\BillOfPurchaseDetail', 'master_code', 'code');
    }

    /**
     * 回傳這個進貨單表頭的供應商
     * @return [type] [description]
     */
    public function supplier()
    {
        return $this->belongsTo('Supplier\Supplier', 'supplier_id', 'id');
    }

    /**
     * 回傳這個進貨單表頭的倉庫
     * @return [type] [description]
     */
    public function warehouse()
    {
        return $this->belongsTo('Warehouse\Warehouse', 'warehouse_id', 'id');
    }
}
