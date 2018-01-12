<?php

namespace App\Repositories;
use App\Page;

class PageRepository
{
    protected $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }
    public function getPageByRouteName($name)
    {
        if (empty($name)) {
            return null;
        }

        return $this->page
            ->where('route_name', $name)
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
     * @return collection            內容是App\Page的record
     */
    public function getSubPagesLevelOne() {
        return $this->page->where('level', 1)->get();
    }
    /**
     * 用$method 組成route_name
     * 接著找出erp_pages.route_name = route_name
     * 而且erp_pages.level = 2的頁面資訊
     * @param  string $method PageController的方法
     * @return collection            內容是App\Page的record
     */
    public function getSubPages($method)
    {
        $parent_page = $this->getPageByRouteName($method);

        return $this->page->where('level', (intval($parent_page->level) + 1))
            ->where('code', 'like', $parent_page->code."%")
            ->where('enabled', 1)
            ->get();
    }

}
