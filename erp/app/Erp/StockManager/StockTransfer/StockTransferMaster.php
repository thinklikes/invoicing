<?php

namespace StockTransfer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockTransferMaster extends Model
{
    use SoftDeletes;

    protected $table = 'erp_stock_transfer_master';
    /**
     * 回傳表頭的倉庫
     * @return [type] [description]
     */
    public function from_warehouse()
    {
        return $this->belongsTo('Warehouse\Warehouse', 'from_warehouse_id', 'id');
    }
    /**
     * 回傳表頭的倉庫
     * @return [type] [description]
     */
    public function to_warehouse()
    {
        return $this->belongsTo('Warehouse\Warehouse', 'to_warehouse_id', 'id');
    }
}
