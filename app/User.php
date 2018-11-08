<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'erp_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'employee_id', 'emp_name',
        'phone', 'out_at', 'remark'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'leavl', 'status'
    ];

    /**
     * 定義多對多關聯，找出目前權限可以瀏覽的頁面
     * @return [type] [description]
     */
    public function auth()
    {
        return $this->belongsTo('Erp\Auth', 'leavl', 'level');
    }
}
