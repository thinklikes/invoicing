<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleOrderMaster extends Model
{
    use SoftDeletes;
    protected $table = 'erp_sale_order_master';
    protected $dates = ['delivery_date', 'created_at', 'updated_at', 'deleted_at', 'date_of_buying'];

    protected $fillable = [
            'code',
            'platform',
            'platform_code',
            'upload_time',
            'date_of_buying',
            'customer_name',
            'customer_tel',
            'customer_email',
            'recipient',
            'recipient_tel',
            'city',
            'zip',
            'address',
            'payway',
            'transfer_time',
            'transfer_code',
            'bank',
            'delivery_method',
            'delivery_date',
            'delivery_time',
            'words_to_boss',
            'taxNumber',
            'InvoiceName',
            'note',
            'pay_status',
            'tag',
            'isCool',
    ];

    public function detail()
    {
        return $this->hasMany('App\SaleOrderDetail', 'master_code', 'code');
    }
}
