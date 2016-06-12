<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockWarehouse extends Model
{
    protected $table = 'stocks_warehouses';

    protected $dates = ['created_at', 'updated_at'];
    /**
     * 回傳這個庫存數量記錄所屬的倉庫
     * @return [type] [description]
     */
    public function warehouse()
    {
        return $this->belongsTo('App\Warehouse', 'warehouse_id', 'id');
    }

    /**
     * 回傳這個庫存數量記錄所屬的料品
     * @return [type] [description]
     */
    public function stock()
    {
        return $this->belongsTo('App\Stock', 'stock_id', 'id');
    }
}
