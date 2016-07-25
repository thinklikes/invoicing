<?php

namespace PayableWriteOff;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * PayableWriteOff\PayableWriteOffMaster
 *
 * @property integer $id
 * @property string $code 付款單號
 * @property integer $supplier_id 供應商的id
 * @property integer $debit_amount 借方總金額
 * @property integer $credit_amount 貸方總金額
 * @property string $note 備註
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Supplier\Supplier $supplier
 * @method static \Illuminate\Database\Query\Builder|\PayableWriteOff\PayableWriteOffMaster whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PayableWriteOff\PayableWriteOffMaster whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\PayableWriteOff\PayableWriteOffMaster whereSupplierId($value)
 * @method static \Illuminate\Database\Query\Builder|\PayableWriteOff\PayableWriteOffMaster whereDebitAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\PayableWriteOff\PayableWriteOffMaster whereCreditAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\PayableWriteOff\PayableWriteOffMaster whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\PayableWriteOff\PayableWriteOffMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PayableWriteOff\PayableWriteOffMaster whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PayableWriteOff\PayableWriteOffMaster whereDeletedAt($value)
 * @mixin \Eloquent
 */
class PayableWriteOffMaster extends Model
{
    use SoftDeletes;

    protected $table = 'erp_payable_write_off_master';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 回傳這個進貨單表頭的供應商
     * @return [type] [description]
     */
    public function supplier()
    {
        return $this->belongsTo('Supplier\Supplier', 'supplier_id', 'id');
    }
}
