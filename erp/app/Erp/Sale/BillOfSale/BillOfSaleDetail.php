<?php

namespace BillOfSale;

use Illuminate\Database\Eloquent\Model;

class BillOfSaleDetail extends Model
{
    protected $table = 'erp_bill_of_sale_detail';

    public $timestamps = false;

    public function stock() {
        return $this->belongsTo('Stock\Stock', 'stock_id', 'id');
    }
}
