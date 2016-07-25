<?php

namespace ReturnOfPurchase;

use Illuminate\Database\Eloquent\Model;

/**
 * ReturnOfPurchase\ReturnOfPurchaseDetail
 *
 * @property integer $id
 * @property string $master_code 進貨退回單的code
 * @property integer $stock_id 料品的id
 * @property float $quantity 進貨數量
 * @property float $no_tax_price 單一個料品的未稅價格
 * @property-read \ReturnOfPurchase\ReturnOfPurchaseMaster $orderMaster
 * @property-read \Stock\Stock $stock
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfPurchase\ReturnOfPurchaseDetail whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfPurchase\ReturnOfPurchaseDetail whereMasterCode($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfPurchase\ReturnOfPurchaseDetail whereStockId($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfPurchase\ReturnOfPurchaseDetail whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfPurchase\ReturnOfPurchaseDetail whereNoTaxPrice($value)
 * @mixin \Eloquent
 */
class ReturnOfPurchaseDetail extends Model
{
    protected $table = 'erp_return_of_purchase_detail';

    public $timestamps = false;

    /**
     * 這個表身細項的表頭資料
     * @return [type] [description]
     */
    public function orderMaster()
    {
        return $this->belongsTo('ReturnOfPurchase\ReturnOfPurchaseMaster', 'master_code', 'code');
    }

    /**
     * 回傳庫存資料
     * @return [type] [description]
     */
    public function stock()
    {
        return $this->belongsTo('Stock\Stock', 'stock_id', 'id');
    }
}
