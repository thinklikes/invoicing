<?php

namespace App\Purchase;

use Illuminate\Database\Eloquent\Model;

class PayableWriteOffDebit extends Model
{
    protected $table = 'payable_write_off_debit';

    public $timestamps = false;
}
