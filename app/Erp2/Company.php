<?php

namespace Erp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Company\Company
 *
 * @mixin \Eloquent
 */
class Company extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'auto_id'; //定義主鍵
    protected $table = 'company_system';
}
