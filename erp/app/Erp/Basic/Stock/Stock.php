<?php

namespace Stock;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;

    protected $table = 'erp_stocks';
    /**
     * 需要被轉換成日期的屬性。
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 回傳這個料品所有的庫存數量
     * @return [type] [description]
     */
    public function stocks_warehouses()
    {
        return $this->hasMany('Stock\StockWarehouse', 'stock_id');
    }

    /**
     * 回傳倉庫資料，可抓出此料品哪幾個倉庫擁有
     * @return [type] [description]
     */
    public function warehouse()
    {
        //dd($this->belongsToMany('App\Option', 'stocks_warehouses', 'stock_id', 'warehouse_id'));
        return $this->belongsToMany('Warehouse\Warehouse', 'stocks_warehouses', 'stock_id', 'warehouse_id');
    }

    /**
     * 回傳這個料品所屬的料品單位
     * @return [type] [description]
     */
    public function unit()
    {
        return $this->belongsTo('Option\Option', 'unit_id');
    }
    /**
     * 回傳這個料品所屬的料品類別
     * @return [type] [description]
     */
    public function stock_class()
    {
        return $this->belongsTo('Option\Option', 'stock_class_id');
    }
}
