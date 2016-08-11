<?php

namespace Erp;

use Illuminate\Database\Eloquent\Model;

/**
 * Company\Company
 *
 * @mixin \Eloquent
 */
class Company extends Model
{
    protected $primaryKey = 'auto_id'; //定義主鍵
    protected $table = 'company_system';
}
