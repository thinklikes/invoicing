<?php

namespace Stock;

use Illuminate\Database\Eloquent\Model;

class StockWarehouse extends Model
{
    protected $table = 'erp_stock_warehouse';

    protected $dates = ['created_at', 'updated_at'];
    /**
     * 回傳這個庫存數量記錄所屬的倉庫
     * @return [type] [description]
     */
    public function warehouse()
    {
        return $this->belongsTo('Warehouse\Warehouse', 'warehouse_id', 'id');
    }

    /**
     * 回傳這個庫存數量記錄所屬的料品
     * @return [type] [description]
     */
    public function stock()
    {
        return $this->belongsTo('Stock\Stock', 'stock_id', 'id');
    }
}
