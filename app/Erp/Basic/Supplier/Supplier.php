<?php

namespace Supplier;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Purchase\Payment;

/**
 * Supplier\Supplier
 *
 * @property integer $id 供應商資料表主鍵
 * @property string $code 供應商編號
 * @property string $name 供應商名稱
 * @property string $shortName 供應商簡稱
 * @property string $boss 負責人
 * @property string $contactPerson 聯絡人
 * @property integer $zip 郵遞區號
 * @property string $address 地址
 * @property string $email 電子郵件
 * @property string $telphone 電話號碼
 * @property string $cellphone 行動電話號碼
 * @property string $fax 傳真號碼
 * @property string $taxNumber 統一編號
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\BillOfPurchase\BillOfPurchaseMaster[] $billOfPurchaseMaster
 * @property-read \Illuminate\Database\Eloquent\Collection|\ReturnOfPurchase\ReturnOfPurchaseMaster[] $returnOfPurchaseMaster
 * @property-read \Illuminate\Database\Eloquent\Collection|\Payment\Payment[] $payment
 * @method static \Illuminate\Database\Query\Builder|\Supplier\Supplier whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Supplier\Supplier whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Supplier\Supplier whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Supplier\Supplier whereShortName($value)
 * @method static \Illuminate\Database\Query\Builder|\Supplier\Supplier whereBoss($value)
 * @method static \Illuminate\Database\Query\Builder|\Supplier\Supplier whereContactPerson($value)
 * @method static \Illuminate\Database\Query\Builder|\Supplier\Supplier whereZip($value)
 * @method static \Illuminate\Database\Query\Builder|\Supplier\Supplier whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\Supplier\Supplier whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Supplier\Supplier whereTelphone($value)
 * @method static \Illuminate\Database\Query\Builder|\Supplier\Supplier whereCellphone($value)
 * @method static \Illuminate\Database\Query\Builder|\Supplier\Supplier whereFax($value)
 * @method static \Illuminate\Database\Query\Builder|\Supplier\Supplier whereTaxNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Supplier\Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Supplier\Supplier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Supplier\Supplier whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Supplier extends Model
{
    use SoftDeletes;

    protected $table = 'erp_suppliers';
    /**
     * 需要被轉換成日期的屬性。
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 設定與進貨單的關聯
     * @return BillOfPurchaseMaster 回傳所屬的進貨單
     */
    public function billOfPurchaseMaster() {
        return $this->hasMany('BillOfPurchase\BillOfPurchaseMaster', 'supplier_id', 'id');
    }

    /**
     * 設定與進貨退回單的關聯
     * @return ReturnOfPurchaseMaster 回傳所屬的進貨退回單
     */
    public function returnOfPurchaseMaster() {
        return $this->hasMany('ReturnOfPurchase\ReturnOfPurchaseMaster', 'supplier_id', 'id');
    }

    /**
     * 設定與付款單的關聯
     * @return payment 回傳所屬的付款單
     */
    public function payment() {
        return $this->hasMany('Payment\Payment', 'supplier_id', 'id');
    }
}
