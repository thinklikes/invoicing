<?php

namespace BillOfPurchase;

use Illuminate\Database\Eloquent\Model;

class BillOfPurchaseDetail extends Model
{
    protected $table = 'erp_bill_of_purchase_detail';

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
