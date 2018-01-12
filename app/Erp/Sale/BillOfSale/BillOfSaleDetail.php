<?php

namespace BillOfSale;

use Illuminate\Database\Eloquent\Model;

/**
 * BillOfSale\BillOfSaleDetail
 *
 * @property integer $id
 * @property string $master_code 銷貨單的code
 * @property integer $stock_id 料品的id
 * @property float $quantity 銷貨數量
 * @property float $no_tax_price 單一個料品的未稅價格
 * @property-read \BillOfSale\BillOfSaleMaster $orderMaster
 * @property-read \Stock\Stock $stock
 * @method static \Illuminate\Database\Query\Builder|\BillOfSale\BillOfSaleDetail whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfSale\BillOfSaleDetail whereMasterCode($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfSale\BillOfSaleDetail whereStockId($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfSale\BillOfSaleDetail whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfSale\BillOfSaleDetail whereNoTaxPrice($value)
 * @mixin \Eloquent
 */
class BillOfSaleDetail extends Model
{
    protected $table = 'erp_bill_of_sale_detail';

    public $timestamps = false;
    protected $fillable = [
        'quantity',
        'price_tax',
    ];
    /**
     * 這個表身細項的表頭資料
     * @return [type] [description]
     */
    public function orderMaster()
    {
        return $this->belongsTo('BillOfSale\BillOfSaleMaster', 'master_code', 'code');
    }

    public function stock() {
        return $this->belongsTo('Stock\Stock', 'stock_id', 'id')->withTrashed();
    }
}
