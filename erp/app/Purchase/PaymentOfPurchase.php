<?php

namespace App\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentOfPurchase extends Model
{
    use SoftDeletes;

    protected $table = 'payment_of_purchase';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
