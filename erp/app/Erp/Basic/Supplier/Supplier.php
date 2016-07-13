<?php

namespace Supplier;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Purchase\BillOfPurchaseMaster;
use App\Purchase\ReturnOfPurchaseMaster;
use App\Purchase\Payment;

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
        return $this->hasMany(BillOfPurchaseMaster::class, 'supplier_id', 'id');
    }

    /**
     * 設定與進貨退回單的關聯
     * @return ReturnOfPurchaseMaster 回傳所屬的進貨退回單
     */
    public function returnOfPurchaseMaster() {
        return $this->hasMany(ReturnOfPurchaseMaster::class, 'supplier_id', 'id');
    }

    /**
     * 設定與付款單的關聯
     * @return payment 回傳所屬的付款單
     */
    public function payment() {
        return $this->hasMany(Payment::class, 'supplier_id', 'id');
    }
}
