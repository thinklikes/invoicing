<?php

namespace Stock;

use Illuminate\Database\Eloquent\Model;

/**
 * Stock\StockWarehouse
 *
 * @property integer $id
 * @property integer $stock_id 料品id
 * @property integer $warehouse_id 倉庫id
 * @property float $inventory 存量
 * @property float $opening_inventory 期初存量
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Warehouse\Warehouse $warehouse
 * @property-read \Stock\Stock $stock
 * @method static \Illuminate\Database\Query\Builder|\Stock\StockWarehouse whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Stock\StockWarehouse whereStockId($value)
 * @method static \Illuminate\Database\Query\Builder|\Stock\StockWarehouse whereWarehouseId($value)
 * @method static \Illuminate\Database\Query\Builder|\Stock\StockWarehouse whereInventory($value)
 * @method static \Illuminate\Database\Query\Builder|\Stock\StockWarehouse whereOpeningInventory($value)
 * @method static \Illuminate\Database\Query\Builder|\Stock\StockWarehouse whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Stock\StockWarehouse whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
