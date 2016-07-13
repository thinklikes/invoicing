<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'erp_employees';
    /**
     * 可以被批量賦值的屬性。
     *
     * @var array
     */
    protected $fillable = ['name'];
}
