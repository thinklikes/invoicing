<?php

namespace ReceivableWriteOff;

use Illuminate\Database\Eloquent\Model;

/**
 * ReceivableWriteOff\ReceivableWriteOffCredit
 *
 * @property integer $id
 * @property string $master_code 表頭單號
 * @property string $credit_type 銷退貨單別
 * @property string $credit_code 銷退貨單號
 * @property integer $credit_amount 銷退貨單沖銷金額
 * @property-read \BillOfSale\BillOfSaleMaster $billOfSale
 * @property-read \ReturnOfSale\ReturnOfSaleMaster $returnOfSale
 * @method static \Illuminate\Database\Query\Builder|\ReceivableWriteOff\ReceivableWriteOffCredit whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ReceivableWriteOff\ReceivableWriteOffCredit whereMasterCode($value)
 * @method static \Illuminate\Database\Query\Builder|\ReceivableWriteOff\ReceivableWriteOffCredit whereCreditType($value)
 * @method static \Illuminate\Database\Query\Builder|\ReceivableWriteOff\ReceivableWriteOffCredit whereCreditCode($value)
 * @method static \Illuminate\Database\Query\Builder|\ReceivableWriteOff\ReceivableWriteOffCredit whereCreditAmount($value)
 * @mixin \Eloquent
 */
class ReceivableWriteOffCredit extends Model
{
    protected $table = 'erp_receivable_write_off_credit';

    public $timestamps = false;

    public function billOfSale()
    {
        return $this->belongsTo('BillOfSale\BillOfSaleMaster', 'credit_code', 'code')
            ->withTrashed();
    }

    public function returnOfSale()
    {
        return $this->belongsTo('ReturnOfSale\ReturnOfSaleMaster', 'credit_code', 'code')
            ->withTrashed();
    }
}
