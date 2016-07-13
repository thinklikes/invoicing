<?php

namespace PayableWriteOff;

use Illuminate\Database\Eloquent\Model;

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
