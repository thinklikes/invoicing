<?php

namespace App\Purchase;

use Illuminate\Database\Eloquent\Model;

class PayableWriteOffCredit extends Model
{
    protected $table = 'payable_write_off_credit';

    public $timestamps = false;

    public function Payment()
    {
        return $this->belongsTo('App\Purchase\Payment', 'credit_code', 'code');
    }
}
