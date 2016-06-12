<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class BillOfPurchaseMaster extends Model
{
    use SoftDeletes;

    protected $table = 'bill_of_purchase_master';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 回傳這個進貨單表頭所有的庫存數量
     * @return [type] [description]
     */
    public function billOfPurchaseDetail()
    {
        return $this->hasMany('App\BillOfPurchaseDetail', 'master_code', 'code');
    }

    /**
     * 回傳這個進貨單表頭的供應商
     * @return [type] [description]
     */
    public function supplier()
    {
        return $this->belongsTo('App\Supplier', 'supplier_id', 'id');
    }

    /**
     * 回傳這個進貨單表頭的倉庫
     * @return [type] [description]
     */
    public function warehouse()
    {
        return $this->belongsTo('App\Warehouse', 'warehouse_id', 'id');
    }
}
