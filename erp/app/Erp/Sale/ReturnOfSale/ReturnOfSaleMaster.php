<?php

namespace ReturnOfSale;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnOfSaleMaster extends Model
{
    use SoftDeletes;

    protected $table = 'erp_return_of_sale_master';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 回傳這個銷貨退回單表頭所有的庫存數量
     * @return [type] [description]
     */
    public function ReturnOfSaleDetail()
    {
        return $this->hasMany('ReturnOfSale\ReturnOfSaleDetail', 'master_code', 'code');
    }

    /**
     * 回傳這個銷貨退回單表頭的供應商
     * @return [type] [description]
     */
    public function supplier()
    {
        return $this->belongsTo('Company\Company', 'Company_id', 'auto_id');
    }

    /**
     * 回傳這個銷貨退回單表頭的倉庫
     * @return [type] [description]
     */
    public function warehouse()
    {
        return $this->belongsTo('Warehouse\Warehouse', 'warehouse_id', 'id');
    }
}
