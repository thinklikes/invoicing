<?php

namespace StockInOut;

use Illuminate\Database\Eloquent\Model;

class StockInOutDetail extends Model
{
    protected $table = 'erp_stock_in_out_detail';

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
