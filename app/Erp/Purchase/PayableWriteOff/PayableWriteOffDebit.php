<?php

namespace PayableWriteOff;

use Illuminate\Database\Eloquent\Model;

/**
 * PayableWriteOff\PayableWriteOffDebit
 *
 * @property integer $id
 * @property string $master_code 表頭單號
 * @property string $debit_type 進退貨單別
 * @property string $debit_code 進退貨單號
 * @property integer $debit_amount 進退貨單沖銷金額
 * @property-read \BillOfPurchase\BillOfPurchaseMaster $billOfPurchase
 * @property-read \ReturnOfPurchase\ReturnOfPurchaseMaster $returnOfPurchase
 * @method static \Illuminate\Database\Query\Builder|\PayableWriteOff\PayableWriteOffDebit whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PayableWriteOff\PayableWriteOffDebit whereMasterCode($value)
 * @method static \Illuminate\Database\Query\Builder|\PayableWriteOff\PayableWriteOffDebit whereDebitType($value)
 * @method static \Illuminate\Database\Query\Builder|\PayableWriteOff\PayableWriteOffDebit whereDebitCode($value)
 * @method static \Illuminate\Database\Query\Builder|\PayableWriteOff\PayableWriteOffDebit whereDebitAmount($value)
 * @mixin \Eloquent
 */
class PayableWriteOffDebit extends Model
{
    protected $table = 'erp_payable_write_off_debit';

    public $timestamps = false;

    public function billOfPurchase()
    {
        return $this->belongsTo('BillOfPurchase\BillOfPurchaseMaster', 'debit_code', 'code');
    }

    public function returnOfPurchase()
    {
        return $this->belongsTo('ReturnOfPurchase\ReturnOfPurchaseMaster', 'debit_code', 'code');
    }
}
