<?php

namespace ReturnOfPurchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * ReturnOfPurchase\ReturnOfPurchaseMaster
 *
 * @property integer $id
 * @property string $code 進貨退回單號
 * @property string $is_paid 是否付款(0:未付款, 1:已付款)
 * @property string $invoice_code 發票號碼
 * @property integer $warehouse_id 倉庫的id
 * @property integer $supplier_id 供應商的id
 * @property string $tax_rate_code 稅別
 * @property integer $total_amount 總金額
 * @property integer $paid_amount 已付金額
 * @property string $note 進貨退回單備註
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\ReturnOfPurchase\ReturnOfPurchaseDetail[] $orderDetail
 * @property-read \Supplier\Supplier $supplier
 * @property-read \Warehouse\Warehouse $warehouse
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfPurchase\ReturnOfPurchaseMaster whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfPurchase\ReturnOfPurchaseMaster whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfPurchase\ReturnOfPurchaseMaster whereIsPaid($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfPurchase\ReturnOfPurchaseMaster whereInvoiceCode($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfPurchase\ReturnOfPurchaseMaster whereWarehouseId($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfPurchase\ReturnOfPurchaseMaster whereSupplierId($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfPurchase\ReturnOfPurchaseMaster whereTaxRateCode($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfPurchase\ReturnOfPurchaseMaster whereTotalAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfPurchase\ReturnOfPurchaseMaster wherePaidAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfPurchase\ReturnOfPurchaseMaster whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfPurchase\ReturnOfPurchaseMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfPurchase\ReturnOfPurchaseMaster whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfPurchase\ReturnOfPurchaseMaster whereDeletedAt($value)
 * @mixin \Eloquent
 */
class ReturnOfPurchaseMaster extends Model
{
    use SoftDeletes;

    protected $table = 'erp_return_of_purchase_master';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 回傳這個表頭所屬的表身細項
     * @return [type] [description]
     */
    public function orderDetail()
    {
        return $this->hasMany('ReturnOfPurchase\ReturnOfPurchaseDetail', 'master_code', 'code');
    }

    /**
     * 回傳這個進貨退回單表頭的供應商
     * @return [type] [description]
     */
    public function supplier()
    {
        return $this->belongsTo('Supplier\Supplier', 'supplier_id', 'id');
    }

    /**
     * 回傳這個進貨退回單表頭的倉庫
     * @return [type] [description]
     */
    public function warehouse()
    {
        return $this->belongsTo('Warehouse\Warehouse', 'warehouse_id', 'id');
    }
}
