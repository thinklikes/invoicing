<?php

namespace StockInLogs;

use Illuminate\Database\Eloquent\Model;

/**
 * StockInLogs\StockInLogs
 *
 * @property integer $id
 * @property string $order_type 異動單據的類型
 * @property string $order_code 異動單據的單號
 * @property integer $warehouse_id 倉庫的id
 * @property integer $stock_id 料品的id
 * @property float $quantity 異動數量
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Query\Builder|\StockInLogs\StockInLogs whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\StockInLogs\StockInLogs whereOrderType($value)
 * @method static \Illuminate\Database\Query\Builder|\StockInLogs\StockInLogs whereOrderCode($value)
 * @method static \Illuminate\Database\Query\Builder|\StockInLogs\StockInLogs whereWarehouseId($value)
 * @method static \Illuminate\Database\Query\Builder|\StockInLogs\StockInLogs whereStockId($value)
 * @method static \Illuminate\Database\Query\Builder|\StockInLogs\StockInLogs whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\StockInLogs\StockInLogs whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\StockInLogs\StockInLogs whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StockInLogs extends Model
{
    protected $table = 'erp_stock_in_logs';

    /**
     * 設定與warehouse的關聯
     * @return Warehouse\Warehouse
     */
    public function warehouse()
    {
        return $this->belongsTo('Warehouse\Warehouse', 'warehouse_id', 'id');
    }

    /**
     * 設定與stock的關聯
     * @return Stock\Stock
     */
    public function stock()
    {
        return $this->belongsTo('Stock\Stock', 'stock_id', 'id');
    }
}
