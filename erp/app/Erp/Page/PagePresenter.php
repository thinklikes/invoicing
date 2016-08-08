<?php

namespace Page;

use Route;

class PagePresenter
{
    private $page;
    private $currentAction = '';
    private $baseControllerNamespace = 'App\\Http\\Controllers\\';

    public function __construct(PageRepository $page)
    {
        $this->page = $page;
        $this->currentAction = $this->exceptBaseNamesapce(Route::currentRouteAction());
    }
    private function exceptBaseNamesapce($currentRoute)
    {
        $currentRoute = str_replace($this->baseControllerNamespace, '', $currentRoute);
        return $currentRoute;
    }
    /**
     * 找出網頁上的路徑
     * @return String -包含超連結的路徑
     */
    public function getCurrentWebRoute()
    {
        //回傳Page\Page
        $this_page = $this->page->getPageByAction($this->currentAction);

        if (is_null($this_page)) {
            return "Cannot find Current Web Route!!";
        }

        $WebRoute = $this->getFullWebRouteRecursivelyByPage($this_page);

        return $WebRoute;
    }

    /**
     * 遞迴地找出輸入頁面的完整路徑
     * @param  Page\Page $this_page 輸入的頁面
     * @return Html string            帶有超連結的完整路徑
     */
    private function getFullWebRouteRecursivelyByPage($this_page)
    {
        $WebRoute = '';

        if (preg_match('/(create|edit|show)$/', $this_page->action)) {
            //在編輯與檢視畫面的設定
            $WebRoute .= '<a href="#">'.$this_page->name.'</a>';
        } else {
            $WebRoute .= '<a href="'.action($this_page->action).'">'.$this_page->name.'</a>';
        }

        if ((strlen($this_page->code)) < 2) {
            //表示此頁已經是根目錄了
            return $WebRoute;
        }

        //回傳Page\Page
        $parent_page = $this->page->getPageByCode(substr($this_page->code, 0, -2));

        $WebRoute = $this->getFullWebRouteRecursivelyByPage($parent_page)." > ".$WebRoute;

        return $WebRoute;
    }

    public function getParentPageUrl()
    {
        //回傳Page\Page
        $this_page = $this->page->getPageByAction($this->currentAction);

        if ((strlen($this_page->code)) < 2) {
            //表示此頁已經是根目錄了
            return null;
        }

        return action(
            $this->page->getPageByCode(
                substr($this_page->code, 0, -2)
            )->action, []
        );
    }
}