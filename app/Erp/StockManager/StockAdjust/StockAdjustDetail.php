<?php

namespace StockAdjust;

use Illuminate\Database\Eloquent\Model;

/**
 * StockAdjust\StockAdjustDetail
 *
 * @property integer $id
 * @property string $master_code 調整單的code
 * @property integer $stock_id 料品的id
 * @property float $quantity 調整數量
 * @property float $no_tax_price 單一個料品的未稅價格
 * @property-read \Stock\Stock $stock
 * @method static \Illuminate\Database\Query\Builder|\StockAdjust\StockAdjustDetail whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\StockAdjust\StockAdjustDetail whereMasterCode($value)
 * @method static \Illuminate\Database\Query\Builder|\StockAdjust\StockAdjustDetail whereStockId($value)
 * @method static \Illuminate\Database\Query\Builder|\StockAdjust\StockAdjustDetail whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\StockAdjust\StockAdjustDetail whereNoTaxPrice($value)
 * @mixin \Eloquent
 */
class StockAdjustDetail extends Model
{
    protected $table = 'erp_stock_adjust_detail';

    public $timestamps = false;

    /**
     * 回傳庫存資料
     * @return [type] [description]
     */
    public function stock()
    {
        return $this->belongsTo('Stock\Stock', 'stock_id', 'id')->withTrashed();
    }
}
