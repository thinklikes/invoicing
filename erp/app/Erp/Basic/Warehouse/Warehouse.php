<?php

namespace Warehouse;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use SoftDeletes;

    protected $table = 'erp_warehouses';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 回傳料品資料，可抓出此倉庫擁有哪些料品
     * @return [type] [description]
     */
    public function warehouse()
    {
        //dd($this->belongsToMany('App\Option', 'stocks_warehouses', 'stock_id', 'warehouse_id'));
        return $this->belongsToMany('App\Stock', 'stocks_warehouses', 'warehouse_id', 'stock_id');
    }
}
