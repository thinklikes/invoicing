<?php

namespace ReceivableWriteOff;

use Illuminate\Database\Eloquent\Model;

/**
 * ReceivableWriteOff\ReceivableWriteOffDebit
 *
 * @property integer $id
 * @property string $master_code 表頭單號
 * @property string $debit_code 收款單號
 * @property integer $debit_amount 收款單沖銷金額
 * @property-read \Receipt\Receipt $Receipt
 * @method static \Illuminate\Database\Query\Builder|\ReceivableWriteOff\ReceivableWriteOffDebit whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ReceivableWriteOff\ReceivableWriteOffDebit whereMasterCode($value)
 * @method static \Illuminate\Database\Query\Builder|\ReceivableWriteOff\ReceivableWriteOffDebit whereDebitCode($value)
 * @method static \Illuminate\Database\Query\Builder|\ReceivableWriteOff\ReceivableWriteOffDebit whereDebitAmount($value)
 * @mixin \Eloquent
 */
class ReceivableWriteOffDebit extends Model
{
    protected $table = 'erp_receivable_write_off_debit';

    public $timestamps = false;

    public function Receipt()
    {
        return $this->belongsTo('Receipt\Receipt', 'debit_code', 'code')
            ->withTrashed();
    }
}
