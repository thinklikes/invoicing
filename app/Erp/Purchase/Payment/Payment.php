<?php

namespace Payment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Payment\Payment
 *
 * @property integer $id
 * @property string $code 付款單號
 * @property string $isWrittenOff 是否沖銷(0:未沖銷, 1:已沖銷)
 * @property string $pay_date 付款日期
 * @property integer $supplier_id 供應商的id
 * @property string $type 付款方式類別
 * @property integer $amount 付款金額
 * @property string $check_code 票據號碼
 * @property string $expiry_date 票據到期日
 * @property string $bank_account 銀行帳號
 * @property string $note 備註
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Supplier\Supplier $supplier
 * @method static \Illuminate\Database\Query\Builder|\Payment\Payment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Payment\Payment whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Payment\Payment whereIsWrittenOff($value)
 * @method static \Illuminate\Database\Query\Builder|\Payment\Payment wherePayDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Payment\Payment whereSupplierId($value)
 * @method static \Illuminate\Database\Query\Builder|\Payment\Payment whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Payment\Payment whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Payment\Payment whereCheckCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Payment\Payment whereExpiryDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Payment\Payment whereBankAccount($value)
 * @method static \Illuminate\Database\Query\Builder|\Payment\Payment whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\Payment\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Payment\Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Payment\Payment whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Payment extends Model
{
    use SoftDeletes;

    protected $table = 'erp_payment';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 回傳這個進貨單表頭的供應商
     * @return [type] [description]
     */
    public function supplier()
    {
        return $this->belongsTo('Supplier\Supplier', 'supplier_id', 'id')->withTrashed();
    }
}
