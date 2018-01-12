<?php

namespace ReceivableWriteOff;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * ReceivableWriteOff\ReceivableWriteOffMaster
 *
 * @property integer $id
 * @property string $code 付款單號
 * @property integer $company_id 客戶的id
 * @property integer $debit_amount 借方總金額
 * @property integer $credit_amount 貸方總金額
 * @property string $note 備註
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Company\Company $company
 * @method static \Illuminate\Database\Query\Builder|\ReceivableWriteOff\ReceivableWriteOffMaster whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ReceivableWriteOff\ReceivableWriteOffMaster whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\ReceivableWriteOff\ReceivableWriteOffMaster whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\ReceivableWriteOff\ReceivableWriteOffMaster whereDebitAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\ReceivableWriteOff\ReceivableWriteOffMaster whereCreditAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\ReceivableWriteOff\ReceivableWriteOffMaster whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\ReceivableWriteOff\ReceivableWriteOffMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ReceivableWriteOff\ReceivableWriteOffMaster whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ReceivableWriteOff\ReceivableWriteOffMaster whereDeletedAt($value)
 * @mixin \Eloquent
 */
class ReceivableWriteOffMaster extends Model
{
    use SoftDeletes;

    protected $table = 'erp_receivable_write_off_master';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 回傳這個進貨單表頭的供應商
     * @return [type] [description]
     */
    public function company()
    {
        return $this->belongsTo('Company\Company', 'company_id', 'auto_id')
            ->withTrashed();
    }
}
