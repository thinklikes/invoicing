<?php

namespace StockInOut;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockInOutMaster extends Model
{
    use SoftDeletes;

    protected $table = 'erp_stock_in_out_master';
    /**
     * 回傳表頭的倉庫
     * @return [type] [description]
     */
    public function warehouse()
    {
        return $this->belongsTo('Warehouse\Warehouse', 'warehouse_id', 'id');
    }
}
