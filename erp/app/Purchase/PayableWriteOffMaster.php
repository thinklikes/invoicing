<?php

namespace App\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayableWriteOffMaster extends Model
{
    use SoftDeletes;

    protected $table = 'payable_write_off_master';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 回傳這個進貨單表頭的供應商
     * @return [type] [description]
     */
    public function supplier()
    {
        return $this->belongsTo('App\Basic\Supplier', 'supplier_id', 'id');
    }
}
