<?php

namespace ReturnOfSale;

use Illuminate\Database\Eloquent\Model;

/**
 * ReturnOfSale\ReturnOfSaleDetail
 *
 * @property integer $id
 * @property string $master_code 進貨退回單的code
 * @property integer $stock_id 料品的id
 * @property float $quantity 進貨數量
 * @property float $no_tax_price 單一個料品的未稅價格
 * @property-read \Stock\Stock $stock
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfSale\ReturnOfSaleDetail whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfSale\ReturnOfSaleDetail whereMasterCode($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfSale\ReturnOfSaleDetail whereStockId($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfSale\ReturnOfSaleDetail whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfSale\ReturnOfSaleDetail whereNoTaxPrice($value)
 * @mixin \Eloquent
 */
class ReturnOfSaleDetail extends Model
{
    protected $table = 'erp_return_of_sale_detail';

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
