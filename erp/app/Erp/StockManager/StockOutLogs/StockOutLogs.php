<?php

namespace StockOutLogs;

use Illuminate\Database\Eloquent\Model;

/**
 * StockOutLogs\StockOutLogs
 *
 * @property integer $id
 * @property string $order_type 異動單據的類型
 * @property string $order_code 異動單據的單號
 * @property integer $warehouse_id 倉庫的id
 * @property integer $stock_id 料品的id
 * @property float $quantity 異動數量
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Query\Builder|\StockOutLogs\StockOutLogs whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\StockOutLogs\StockOutLogs whereOrderType($value)
 * @method static \Illuminate\Database\Query\Builder|\StockOutLogs\StockOutLogs whereOrderCode($value)
 * @method static \Illuminate\Database\Query\Builder|\StockOutLogs\StockOutLogs whereWarehouseId($value)
 * @method static \Illuminate\Database\Query\Builder|\StockOutLogs\StockOutLogs whereStockId($value)
 * @method static \Illuminate\Database\Query\Builder|\StockOutLogs\StockOutLogs whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\StockOutLogs\StockOutLogs whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\StockOutLogs\StockOutLogs whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StockOutLogs extends Model
{
    protected $table = 'erp_stock_out_logs';
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
