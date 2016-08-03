<?php

namespace Page;

class PageRepository
{
    protected $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }
    public function getPageByAction($action)
    {
        if (empty($action)) {
            return null;
        }

        return $this->page
            ->where('action', $action)
            ->first();
    }

    public function getPageByCode($code)
    {
        return $this->page
            ->where('code', $code)
            ->first();
    }

    /**
     * 抓出erp_pages.level = 1的頁面資訊
     * @return collection            內容是Page\Page的record
     */
    public function getSubPagesLevelOne() {
        return $this->page->where('level', 1)->get();
    }
    /**
     * 用$method 組成action
     * 接著找出erp_pages.action = action
     * 而且erp_pages.level = 2的頁面資訊
     * @param  string $method PageController的方法
     * @return collection            內容是Page\Page的record
     */
    public function getSubPagesLeveltwoByMethod($method)
    {
        $parent_code = $this->getPageByAction('PageController@'.$method)->code;

        return $this->page->where('level', 2)
            ->where('code', 'like', $parent_code."%")
            ->get();
    }

}
