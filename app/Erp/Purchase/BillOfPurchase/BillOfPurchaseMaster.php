<?php

namespace BillOfPurchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * BillOfPurchase\BillOfPurchaseMaster
 *
 * @property integer $id
 * @property string $code 進貨單號
 * @property string $is_paid 是否付款(0:未付款, 1:已付款)
 * @property string $invoice_code 發票號碼
 * @property integer $warehouse_id 倉庫的id
 * @property integer $supplier_id 供應商的id
 * @property string $tax_rate_code 稅別
 * @property integer $total_amount 總金額
 * @property integer $paid_amount 已付金額
 * @property string $note 進貨單備註
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\BillOfPurchase\BillOfPurchaseDetail[] $orderDetail
 * @property-read \Supplier\Supplier $supplier
 * @property-read \Warehouse\Warehouse $warehouse
 * @method static \Illuminate\Database\Query\Builder|\BillOfPurchase\BillOfPurchaseMaster whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfPurchase\BillOfPurchaseMaster whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfPurchase\BillOfPurchaseMaster whereIsPaid($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfPurchase\BillOfPurchaseMaster whereInvoiceCode($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfPurchase\BillOfPurchaseMaster whereWarehouseId($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfPurchase\BillOfPurchaseMaster whereSupplierId($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfPurchase\BillOfPurchaseMaster whereTaxRateCode($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfPurchase\BillOfPurchaseMaster whereTotalAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfPurchase\BillOfPurchaseMaster wherePaidAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfPurchase\BillOfPurchaseMaster whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfPurchase\BillOfPurchaseMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfPurchase\BillOfPurchaseMaster whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfPurchase\BillOfPurchaseMaster whereDeletedAt($value)
 * @mixin \Eloquent
 */
class BillOfPurchaseMaster extends Model
{
    use SoftDeletes;

    protected $table = 'erp_bill_of_purchase_master';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 回傳這個表頭所屬的表身細項
     * @return [type] [description]
     */
    public function orderDetail()
    {
        return $this->hasMany('BillOfPurchase\BillOfPurchaseDetail', 'master_code', 'code');
    }

    /**
     * 回傳這個進貨單表頭的供應商
     * @return [type] [description]
     */
    public function supplier()
    {
        return $this->belongsTo('Supplier\Supplier', 'supplier_id', 'id')->withTrashed();
    }

    /**
     * 回傳這個進貨單表頭的倉庫
     * @return [type] [description]
     */
    public function warehouse()
    {
        return $this->belongsTo('Warehouse\Warehouse', 'warehouse_id', 'id');
    }
}
