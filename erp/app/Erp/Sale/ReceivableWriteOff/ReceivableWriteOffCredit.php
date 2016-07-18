<?php

namespace ReceivableWriteOff;

use Illuminate\Database\Eloquent\Model;

class ReceivableWriteOffCredit extends Model
{
    protected $table = 'erp_receivable_write_off_credit';

    public $timestamps = false;

    public function billOfSale()
    {
        return $this->belongsTo('BillOfSale\BillOfSaleMaster', 'credit_code', 'code');
    }

    public function returnOfSale()
    {
        return $this->belongsTo('ReturnOfSale\ReturnOfSaleMaster', 'credit_code', 'code');
    }
}
