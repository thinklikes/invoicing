<?php

namespace Receipt;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Receipt\Receipt
 *
 * @property integer $id
 * @property string $code 收款單號
 * @property string $isWrittenOff 是否沖銷(0:未沖銷, 1:已沖銷)
 * @property string $receive_date 收款日期
 * @property integer $company_id 客戶的id
 * @property string $type 收款方式類別
 * @property integer $amount 收款金額
 * @property string $check_code 票據號碼
 * @property string $expiry_date 票據到期日
 * @property string $bank_account 銀行帳號
 * @property string $note 備註
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Company\Company $company
 * @method static \Illuminate\Database\Query\Builder|\Receipt\Receipt whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Receipt\Receipt whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Receipt\Receipt whereIsWrittenOff($value)
 * @method static \Illuminate\Database\Query\Builder|\Receipt\Receipt whereReceiveDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Receipt\Receipt whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\Receipt\Receipt whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Receipt\Receipt whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Receipt\Receipt whereCheckCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Receipt\Receipt whereExpiryDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Receipt\Receipt whereBankAccount($value)
 * @method static \Illuminate\Database\Query\Builder|\Receipt\Receipt whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\Receipt\Receipt whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Receipt\Receipt whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Receipt\Receipt whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Receipt extends Model
{
    use SoftDeletes;

    protected $table = 'erp_receipt';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 回傳這個進貨單表頭的供應商
     * @return [type] [description]
     */
    public function company()
    {
        return $this->belongsTo('Company\Company', 'company_id', 'auto_id');
    }
}
