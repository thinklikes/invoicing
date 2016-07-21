<?php

namespace StockAdjust;

use Illuminate\Database\Eloquent\Model;

class StockAdjustDetail extends Model
{
    protected $table = 'erp_stock_adjust_detail';

    public $timestamps = false;

    /**
     * 回傳庫存資料
     * @return [type] [description]
     */
    public function stock()
    {
        return $this->belongsTo('Stock\Stock', 'stock_id', 'id');
    }
}
