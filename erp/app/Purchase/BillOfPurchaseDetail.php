<?php

namespace App\Purchase;

use Illuminate\Database\Eloquent\Model;

class BillOfPurchaseDetail extends Model
{
    protected $table = 'bill_of_purchase_detail';

    public $timestamps = false;

    /**
     * 回傳庫存資料
     * @return [type] [description]
     */
    public function stock()
    {
        return $this->belongsTo('App\Stock', 'stock_id', 'id');
    }
}
