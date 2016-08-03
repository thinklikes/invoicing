<?php

namespace Page;

class PagePresenter
{
    protected $page;
    private $baseControllerNamespace = 'App\\Http\\Controllers\\';

    public function __construct(PageRepository $page)
    {
        $this->page = $page;
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
    public function getCurrentWebRoute($currentRoute)
    {
        if (is_null($currentRoute)) {
            return "Cannot find Current Web Route!!";
        }
        $action    = $this->exceptBaseNamesapce($currentRoute);

        $this_page = $this->page->getPageByAction($action);

        if (is_null($this_page->code)) {
            return "Cannot find Current Web Route!!";
        }
        $WebRoute = '';
        $WebRoute .= $this->getParentPageRouteByCode($this_page->code);
        $WebRoute .= '<a href="#">'.$this_page->name.'</a>';

        return $WebRoute;
    }

    public function getParentPageRouteByCode($code)
    {
        if ((strlen($code)) < 2) {
            return '';
        }
        $parent_code = substr($code, 0, -2);
        $parent_page = $this->page->getPageByCode($parent_code);

        $WebRoute = $this->getParentPageRouteByCode($parent_code);
        $WebRoute .= '<a href="'.action($parent_page->action).'">'.$parent_page->name.'</a>';

        return $WebRoute . " > ";
    }
}