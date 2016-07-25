<?php

namespace StockTransfer;

use Illuminate\Database\Eloquent\Model;

/**
 * StockTransfer\StockTransferDetail
 *
 * @property integer $id
 * @property string $master_code 調整單的code
 * @property integer $stock_id 料品的id
 * @property float $quantity 調整數量
 * @property float $no_tax_price 單一個料品的未稅價格
 * @property-read \Stock\Stock $stock
 * @method static \Illuminate\Database\Query\Builder|\StockTransfer\StockTransferDetail whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\StockTransfer\StockTransferDetail whereMasterCode($value)
 * @method static \Illuminate\Database\Query\Builder|\StockTransfer\StockTransferDetail whereStockId($value)
 * @method static \Illuminate\Database\Query\Builder|\StockTransfer\StockTransferDetail whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\StockTransfer\StockTransferDetail whereNoTaxPrice($value)
 * @mixin \Eloquent
 */
class StockTransferDetail extends Model
{
    protected $table = 'erp_stock_transfer_detail';

    public $timestamps = false;

    /**
     * 回傳庫存資料
     * @return [type] [description]
     */
    public function stock()
    {
        return $this->belongsTo('Stock\Stock', 'stock_id', 'id');
    }
}
