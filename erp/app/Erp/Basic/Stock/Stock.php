<?php

namespace Stock;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Stock\Stock
 *
 * @property integer $id 料品資料表主鍵
 * @property string $code 料品代號
 * @property string $name 料品名稱
 * @property string $stock_class_id 料品類別的id
 * @property string $unit_id 料品單位的id
 * @property float $net_weight 淨重
 * @property float $gross_weight 毛重
 * @property string $note 備註
 * @property float $no_tax_price_of_purchased 進貨價格
 * @property float $no_tax_price_of_sold 銷貨價格
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Stock\StockWarehouse[] $stocks_warehouses
 * @property-read \Illuminate\Database\Eloquent\Collection|\Warehouse\Warehouse[] $warehouse
 * @property-read \Option\Option $unit
 * @property-read \Option\Option $stock_class
 * @method static \Illuminate\Database\Query\Builder|\Stock\Stock whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Stock\Stock whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Stock\Stock whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Stock\Stock whereStockClassId($value)
 * @method static \Illuminate\Database\Query\Builder|\Stock\Stock whereUnitId($value)
 * @method static \Illuminate\Database\Query\Builder|\Stock\Stock whereNetWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\Stock\Stock whereGrossWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\Stock\Stock whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\Stock\Stock whereNoTaxPriceOfPurchased($value)
 * @method static \Illuminate\Database\Query\Builder|\Stock\Stock whereNoTaxPriceOfSold($value)
 * @method static \Illuminate\Database\Query\Builder|\Stock\Stock whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Stock\Stock whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Stock\Stock whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Stock extends Model
{
    use SoftDeletes;

    protected $table = 'erp_stocks';
    /**
     * 需要被轉換成日期的屬性。
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 回傳這個料品所有的庫存數量
     * @return [type] [description]
     */
    public function stocks_warehouses()
    {
        return $this->hasMany('Stock\StockWarehouse', 'stock_id');
    }

    /**
     * 回傳倉庫資料，可抓出此料品哪幾個倉庫擁有
     * @return [type] [description]
     */
    public function warehouse()
    {
        //dd($this->belongsToMany('App\Option', 'stocks_warehouses', 'stock_id', 'warehouse_id'));
        return $this->belongsToMany('Warehouse\Warehouse', 'stocks_warehouses', 'stock_id', 'warehouse_id');
    }

    /**
     * 回傳這個料品所屬的料品單位
     * @return [type] [description]
     */
    public function unit()
    {
        return $this->belongsTo('Option\Option', 'unit_id');
    }
    /**
     * 回傳這個料品所屬的料品類別
     * @return [type] [description]
     */
    public function stock_class()
    {
        return $this->belongsTo('Option\Option', 'stock_class_id');
    }
}
