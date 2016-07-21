<?php

namespace StockAdjust;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockAdjustMaster extends Model
{
    use SoftDeletes;

    protected $table = 'erp_stock_adjust_master';

    /**
     * 回傳這個表頭所屬的表身細項
     * @return [type] [description]
     */
    public function orderDetail()
    {
        return $this->hasMany('StockAdjust\StockAdjustDetail', 'master_code', 'code');
    }

    /**
     * 回傳表頭的倉庫
     * @return [type] [description]
     */
    public function warehouse()
    {
        return $this->belongsTo('Warehouse\Warehouse', 'warehouse_id', 'id');
    }
}
