<?php

namespace Page;

use Illuminate\Http\Request;

use App\Http\Requests;

class PageService
{
    private $page;

    public function __construct(PageRepository $page)
    {
        $this->page = $page;
    }
    public function getSubPagesOfIndex(Request $request, $method = '')
    {
        //取得使用者模型
        $user = $request->user();
        //判斷是否為Admin
        $isSuperAdmin = $user->can('isSuperAdmin', $user->leavl);

        $pages = $this->page->getSubPagesLevelOne();

        if (!$isSuperAdmin) {
            $pages = $pages->filter(function ($item, $key) {
                return $item->enabled == 1;
            });

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

    public function getSubPagesOfSubIndex(Request $request, $method = '')
    {
        //取得使用者模型
        $user = $request->user();
        //判斷是否為Admin
        $isSuperAdmin = $user->can('isSuperAdmin', $user->leavl);

        $pages = $this->page->getSubPagesLeveltwoByMethod($method);

        if (!$isSuperAdmin) {
            $pages = $pages->filter(function ($item, $key) {
                return $item->enabled == 1;
            });

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