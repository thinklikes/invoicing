<?php

namespace PayableWriteOff;

use Illuminate\Database\Eloquent\Model;

/**
 * PayableWriteOff\PayableWriteOffCredit
 *
 * @property integer $id
 * @property string $master_code 表頭單號
 * @property string $credit_code 付款單號
 * @property integer $credit_amount 付款單沖銷金額
 * @property-read \Payment\Payment $Payment
 * @method static \Illuminate\Database\Query\Builder|\PayableWriteOff\PayableWriteOffCredit whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PayableWriteOff\PayableWriteOffCredit whereMasterCode($value)
 * @method static \Illuminate\Database\Query\Builder|\PayableWriteOff\PayableWriteOffCredit whereCreditCode($value)
 * @method static \Illuminate\Database\Query\Builder|\PayableWriteOff\PayableWriteOffCredit whereCreditAmount($value)
 * @mixin \Eloquent
 */
class PayableWriteOffCredit extends Model
{
    protected $table = 'erp_payable_write_off_credit';

    public $timestamps = false;

    public function Payment()
    {
        return $this->belongsTo('Payment\Payment', 'credit_code', 'code')
            ->withTrashed();
    }
}
