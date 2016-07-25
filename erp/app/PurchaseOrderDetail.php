<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PurchaseOrderDetail
 *
 * @property-read \Stock\Stock $stock
 * @mixin \Eloquent
 */
class PurchaseOrderDetail extends Model
{
    protected $table = 'bill_of_purchase_detail';

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
