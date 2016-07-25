<?php

namespace BillOfSale;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * BillOfSale\BillOfSaleMaster
 *
 * @property integer $id
 * @property string $code 銷貨單號
 * @property string $is_received 是否收款(0:未收款, 1:已收款)
 * @property string $invoice_code 發票號碼
 * @property integer $warehouse_id 倉庫的id
 * @property integer $company_id 客戶的id
 * @property string $tax_rate_code 稅別
 * @property integer $total_amount 總金額
 * @property integer $received_amount 已收金額
 * @property string $note 備註
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\BillOfSale\BillOfSaleDetail[] $orderDetail
 * @property-read \Company\Company $company
 * @property-read \Warehouse\Warehouse $warehouse
 * @method static \Illuminate\Database\Query\Builder|\BillOfSale\BillOfSaleMaster whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfSale\BillOfSaleMaster whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfSale\BillOfSaleMaster whereIsReceived($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfSale\BillOfSaleMaster whereInvoiceCode($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfSale\BillOfSaleMaster whereWarehouseId($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfSale\BillOfSaleMaster whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfSale\BillOfSaleMaster whereTaxRateCode($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfSale\BillOfSaleMaster whereTotalAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfSale\BillOfSaleMaster whereReceivedAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfSale\BillOfSaleMaster whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfSale\BillOfSaleMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfSale\BillOfSaleMaster whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\BillOfSale\BillOfSaleMaster whereDeletedAt($value)
 * @mixin \Eloquent
 */
class BillOfSaleMaster extends Model
{
    use SoftDeletes;

    protected $table = 'erp_bill_of_sale_master';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 回傳這個表頭所屬的表身細項
     * @return [type] [description]
     */
    public function orderDetail()
    {
        return $this->hasMany('BillOfSale\BillOfSaleDetail', 'master_code', 'code');
    }

    /**
     * 回傳這個進貨單表頭的供應商
     * @return [type] [description]
     */
    public function company()
    {
        return $this->belongsTo('Company\Company', 'company_id', 'auto_id');
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
