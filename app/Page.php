<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Page
 *
 * @property integer $id
 * @property string $code menu的代號
 * @property string $name menu的名稱
 * @property boolean $level menu的等級
 * @property string $action menu對應到的action
 * @property string $enabled 這個頁面是否使用
 * @mixin \Eloquent
 */
class Page extends Model
{
    protected $table = 'erp_pages';
    //設定主鍵是code欄位
    protected $primaryKey = 'code';
    public $timestamps = false;

    /**
     * 定義多對多關聯，找出目前USER可以瀏覽的頁面
     * @return [type] [description]
     */
    public function auths()
    {
        return $this->belongsToMany('Erp\Auth', 'erp_page_auths', 'page_code', 'auth_level');
    }
}
