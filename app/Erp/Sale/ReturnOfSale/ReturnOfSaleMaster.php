<?php

namespace ReturnOfSale;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * ReturnOfSale\ReturnOfSaleMaster
 *
 * @property integer $id
 * @property string $code 銷貨退回單號
 * @property string $is_received 是否收款(0:未付款, 1:已付款)
 * @property string $invoice_code 發票號碼
 * @property integer $warehouse_id 倉庫的id
 * @property integer $company_id 客戶的id
 * @property string $tax_rate_code 稅別
 * @property integer $total_amount 總金額
 * @property integer $received_amount 已收金額
 * @property string $note 銷貨退回單備註
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\ReturnOfSale\ReturnOfSaleDetail[] $orderDetail
 * @property-read \Company\Company $company
 * @property-read \Warehouse\Warehouse $warehouse
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfSale\ReturnOfSaleMaster whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfSale\ReturnOfSaleMaster whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfSale\ReturnOfSaleMaster whereIsReceived($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfSale\ReturnOfSaleMaster whereInvoiceCode($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfSale\ReturnOfSaleMaster whereWarehouseId($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfSale\ReturnOfSaleMaster whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfSale\ReturnOfSaleMaster whereTaxRateCode($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfSale\ReturnOfSaleMaster whereTotalAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfSale\ReturnOfSaleMaster whereReceivedAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfSale\ReturnOfSaleMaster whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfSale\ReturnOfSaleMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfSale\ReturnOfSaleMaster whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ReturnOfSale\ReturnOfSaleMaster whereDeletedAt($value)
 * @mixin \Eloquent
 */
class ReturnOfSaleMaster extends Model
{
    use SoftDeletes;

    protected $table = 'erp_return_of_sale_master';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 回傳這個表頭所屬的表身細項
     * @return [type] [description]
     */
    public function orderDetail()
    {
        return $this->hasMany('ReturnOfSale\ReturnOfSaleDetail', 'master_code', 'code');
    }

    /**
     * 回傳這個銷貨退回單表頭的供應商
     * @return [type] [description]
     */
    public function company()
    {
        return $this->belongsTo('Company\Company', 'company_id', 'auto_id')
            ->withTrashed();
    }

    /**
     * 回傳這個銷貨退回單表頭的倉庫
     * @return [type] [description]
     */
    public function warehouse()
    {
        return $this->belongsTo('Warehouse\Warehouse', 'warehouse_id', 'id');
    }
}
