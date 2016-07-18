<?php

namespace ReceivableWriteOff;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivableWriteOffMaster extends Model
{
    use SoftDeletes;

    protected $table = 'erp_receivable_write_off_master';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 回傳這個進貨單表頭的供應商
     * @return [type] [description]
     */
    public function company()
    {
        return $this->belongsTo('Company\Company', 'company_id', 'auto_id');
    }
}
