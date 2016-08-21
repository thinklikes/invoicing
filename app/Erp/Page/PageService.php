<?php

namespace Page;

use DB;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;

class PageService
{
    private $page;

    public function __construct(PageRepository $page)
    {
        $this->page = $page;
    }
    /**
     * 找出首頁的子頁面資料
     * @param  User   $user 執行此程式的使用者
     * @return Collection       內容是Page\Page的集合
     */
    public function getSubPagesOfIndex(User $user)
    {

        //判斷是否為Admin
        $isSuperAdmin = $user->can('isSuperAdmin', $user->leavl);
        //找出首頁的子頁面，whereLoose非嚴格比對
        $pages = $user->auth->pages->whereLoose('level', 1);

        if (!$isSuperAdmin) {
            $pages = $pages->whereLoose('enabled', 1);
        } else {
            $pages = $pages->map(function ($item, $key) {
                if ($item->enabled == 0) {
                    $item->name = "[未啟用] ".$item->name;
                }
                return $item;
            });
        }

        return $pages;
    }
    /**
     * 取得第二層頁面的子頁面資料
     *
     * @param  User   $user   [description]
     * @param  string $method [description]
     *     basic        => 基本資料管理
     *     purchase     => 進貨作業
     *     sale         => 銷貨作業
     *     stockManager => 庫存管理作業
     *     system       => 系統
     * @return Collection       內容是Page\Page的集合
     */
    public function getSubPagesOfSubIndex(User $user, $method = '')
    {
        //判斷是否為Admin
        $isSuperAdmin = $user->can('isSuperAdmin', $user->leavl);

        $parent_code = $this->page->getPageByAction('PageController@'.$method)->code;
        //找出此頁面的子頁面，whereLoose非嚴格比對
        $pages = $user->auth->pages->whereLoose('level', 2)
            ->filter(function($item, $key) use ($parent_code) {
                return preg_match("/^$parent_code/", $item->code);
            });

        if (!$isSuperAdmin) {
            $pages = $pages->whereLoose('enabled', 1);

        } else {
            $pages = $pages->map(function ($item, $key) {
                if ($item->enabled == 0) {
                    $item->name = "[未啟用] ".$item->name;
                }
                return $item;
            });
        }

        return $pages;
    }
}