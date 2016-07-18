<?php

namespace ReceivableWriteOff;

use Illuminate\Database\Eloquent\Model;

class ReceivableWriteOffDebit extends Model
{
    protected $table = 'erp_receivable_write_off_debit';

    public $timestamps = false;

    public function Receipt()
    {
        return $this->belongsTo('Receipt\Receipt', 'debit_code', 'code');
    }
}
