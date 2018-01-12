<?php

namespace BillOfPurchase;

use Illuminate\Database\Eloquent\Model;

/**
 * BillOfPurchase\BillOfPurchaseDetail
 *
 * @property integer $id
 * @property string $master_code 進貨單的code
 * @property integer $stock_id 料品的id
 * @property float $quantity 進貨數量
 * @property float $no_tax_price 單一個料品的未稅價格
 * @property-read \BillOfPurchase\BillOfPurchaseMaster $orderMaster
 * @property-read \Stock\Stock $stock
 * @method static \Illuminate\Database\Query\Builder|\BillOfPurchase\BillOfPurchaseDetail whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfPurchase\BillOfPurchaseDetail whereMasterCode($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfPurchase\BillOfPurchaseDetail whereStockId($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfPurchase\BillOfPurchaseDetail whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfPurchase\BillOfPurchaseDetail whereNoTaxPrice($value)
 * @mixin \Eloquent
 */
class BillOfPurchaseDetail extends Model
{
    protected $table = 'erp_bill_of_purchase_detail';

    public $timestamps = false;

    /**
     * 這個表身細項的表頭資料
     * @return [type] [description]
     */
    public function orderMaster()
    {
        return $this->belongsTo('BillOfPurchase\BillOfPurchaseMaster', 'code', 'master_code');
    }

    /**
     * 回傳庫存資料
     * @return [type] [description]
     */
    public function stock()
    {
        return $this->belongsTo('Stock\Stock', 'stock_id', 'id')->withTrashed();
    }
}
