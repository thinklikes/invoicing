<?php

namespace Erp;

use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    protected $table = 'erp_auths';
    protected $primaryKey = 'level';
    /**
     * 定義關聯，找出目前權限所有的使用者
     * @return [type] [description]
     */
    public function users()
    {
        return $this->hasMany('App\User', 'level', 'leavl');
    }

    /**
     * 定義多對多關聯，找出目前權限可以瀏覽的頁面
     * @return [type] [description]
     */
    public function pages()
    {
        return $this->belongsToMany('Page\Page', 'erp_page_auths', 'auth_level', 'page_code');
    }
}
