<?php

namespace PayableWriteOff;

use Illuminate\Database\Eloquent\Model;

class PayableWriteOffCredit extends Model
{
    protected $table = 'erp_payable_write_off_credit';

    public $timestamps = false;

    public function Payment()
    {
        return $this->belongsTo('Payment\Payment', 'credit_code', 'code');
    }
}
