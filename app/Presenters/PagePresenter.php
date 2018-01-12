<?php

namespace App\Presenters;

use App\Repositories\PageRepository;
use Route;

class PagePresenter
{
    private $page;
    private $currentRouteName = '';
    private $baseControllerNamespace = 'App\\Http\\Controllers\\';

    public function __construct(PageRepository $page)
    {
        $this->page = $page;
        $this->currentRouteName = Route::current()->getName();
    }

    /**
     * 找出網頁上的路徑
     * @return String -包含超連結的路徑
     */
    public function getCurrentWebRoute()
    {
        //回傳App\Page
        $this_page = $this->page->getPageByRouteName($this->currentRouteName);

        if (is_null($this_page)) {
            return "Cannot find Current Web Route!!";
        }

        $WebRoute = $this->getFullWebRouteRecursivelyByPage($this_page, 0);

        return $WebRoute;
    }

    /**
     * 遞迴地找出輸入頁面的完整路徑
     * @param  App\Page $this_page 輸入的頁面
     * @return Html string            帶有超連結的完整路徑
     */
    private function getFullWebRouteRecursivelyByPage($this_page, $count)
    {
        $WebRoute = '';

        if ($count == 0) {
            //在編輯與檢視畫面的設定
            $WebRoute .= $this_page->name;
        } else {
            $WebRoute .= '<a href="'.route($this_page->route_name).'">'.$this_page->name.'</a>';
        }

        if ((strlen($this_page->code)) < 2) {
            //表示此頁已經是根目錄了
            return $WebRoute;
        }
        $count ++;
        //回傳App\Page
        $parent_page = $this->page->getPageByCode(substr($this_page->code, 0, -2));

        $WebRoute = $this->getFullWebRouteRecursivelyByPage($parent_page, $count)." > ".$WebRoute;

        return $WebRoute;
    }

    public function getParentPageUrl()
    {
        //回傳App\Page
        $this_page = $this->page->getPageByRouteName($this->currentRouteName);

        if ((strlen($this_page->code)) < 2) {
            //表示此頁已經是根目錄了
            //回傳首頁網址
            return url('/');
        }

        $parent_pageCode = substr($this_page->code, 0, -2);

        $parent_page = $this->page->getPageByCode($parent_pageCode);

        return route($parent_page->route_name);
    }

    /*
     * 取得所有菜單
    */
    public function getMenu()
    {
        //找出level = 1的所有頁面
        $parent_pages = $this->page->getSubPagesLevelOne();

        $menu = '';
        foreach ($parent_pages as $key => $parent_page) {
            // level = 1頁面的url
            $parent_url = route($parent_page->route_name);
            $menu .= '<li class="dropdown">';
            $menu .= '<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">'
                .$parent_page->name.'</a>';

            $menu .= '<ul class="dropdown-menu" role="menu">';
            $childrens = $this->page->getSubPages($parent_page->route_name);
            foreach ($childrens as $children) {
                $children_url = route($children->route_name);

                $menu .= '<li><a href="'.$children_url.'"><i class="fa fa-dot-circle-o"></i> '
                    .$children->name.'</a></li>';
            }
            $menu .= '</ul>';
            $menu .= '</li>';
        }

        return $menu;
                    //         <li class="dropdown">
                    //     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    //         {{ Auth::user()->name }} <span class="caret"></span>
                    //     </a>
                    //     <ul class="dropdown-menu" role="menu">
                    //         <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                    //     </ul>
                    // </li>
    }
}