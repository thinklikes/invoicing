<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleOrderDetail extends Model
{
    protected $table = 'erp_sale_order_detail';

    public $timestamps = false;
    protected $fillable = [
        'master_code',
        'item',
        'price',
        'quantity',
    ];
}
