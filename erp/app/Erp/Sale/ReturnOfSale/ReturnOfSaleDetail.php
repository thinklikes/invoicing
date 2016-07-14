<?php

namespace ReturnOfSale;

use Illuminate\Database\Eloquent\Model;

class ReturnOfSaleDetail extends Model
{
    protected $table = 'erp_return_of_sale_detail';

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
