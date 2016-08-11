<?php

namespace Warehouse;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Warehouse\Warehouse
 *
 * @property integer $id
 * @property string $code 倉庫代碼
 * @property string $name 倉庫名稱
 * @property string $comment 倉庫說明
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Stock\Stock[] $StockWarehouse
 * @method static \Illuminate\Database\Query\Builder|\Warehouse\Warehouse whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Warehouse\Warehouse whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Warehouse\Warehouse whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Warehouse\Warehouse whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\Warehouse\Warehouse whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Warehouse\Warehouse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Warehouse\Warehouse whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Warehouse extends Model
{
    use SoftDeletes;

    protected $table = 'erp_warehouses';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 回傳料品資料，可抓出此倉庫擁有哪些料品
     * @return [type] [description]
     */
    public function StockWarehouse()
    {
        //dd($this->belongsToMany('App\Option', 'stocks_warehouses', 'stock_id', 'warehouse_id'));
        return $this->belongsToMany('Stock\Stock', 'erp_stock_warehouse', 'warehouse_id', 'stock_id');
    }

    /**
     * 回傳料品資料，可抓出此倉庫擁有哪幾個料品
     * @return [type] [description]
     */
    public function stock()
    {
        //dd($this->belongsToMany('App\Option', 'stocks_warehouses', 'stock_id', 'warehouse_id'));
        return $this->belongsToMany('Stock\Stock', 'erp_stock_warehouse', 'warehouse_id', 'stock_id');
    }
}
