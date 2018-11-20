<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Page
 * @package App
 */
class Page extends Model
{
    protected $table = 'erp_pages';

    //設定主鍵是code欄位
    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'code', 'name', 'level', 'enabled', 'route_name'
    ];
    /**
     * 定義多對多關聯，找出目前USER可以瀏覽的頁面
     * @return [type] [description]
     */
    public function auths()
    {
        return $this->belongsToMany('Erp\Auth', 'erp_page_auths', 'page_code', 'auth_level');
    }
}
