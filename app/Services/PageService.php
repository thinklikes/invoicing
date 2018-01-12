<?php

namespace App\Services;

use DB;
use App\User;
use App\Http\Requests;
use App\Repositories\PageRepository;
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
     * @return Collection       內容是App\Page的集合
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
     * @return Collection       內容是App\Page的集合
     */
    public function getSubPagesByUser(User $user, $method = '')
    {
        //判斷是否為Admin
        $isSuperAdmin = $user->can('isSuperAdmin', $user->leavl);

        $parent_page = $this->page->getPageByRouteName($method);

        $parent_code = $parent_page->code;

        $parent_level = $parent_page->level;
        //找出此頁面的子頁面，whereLoose非嚴格比對

        $pages = $user->auth->pages()->where('level', intval($parent_level) + 1)
            ->where('code', 'like', $parent_code.'%')
            ->get();


        if (!$isSuperAdmin) {
            return $pages->whereLoose('enabled', 1);

        }
        return $pages->map(function ($item, $key) {
            if ($item->enabled == 0) {
                $item->name = "[未啟用] ".$item->name;
            }
            return $item;
        });
    }
}