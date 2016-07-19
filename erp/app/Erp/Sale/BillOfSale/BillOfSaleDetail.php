<?php

namespace BillOfSale;

use Illuminate\Database\Eloquent\Model;

class BillOfSaleDetail extends Model
{
    protected $table = 'erp_bill_of_sale_detail';

    public $timestamps = false;

    /**
     * 這個表身細項的表頭資料
     * @return [type] [description]
     */
    public function orderMaster()
    {
        return $this->belongsTo('BillOfSale\BillOfSaleMaster', 'master_code', 'code');
    }

    public function stock() {
        return $this->belongsTo('Stock\Stock', 'stock_id', 'id');
    }
}
