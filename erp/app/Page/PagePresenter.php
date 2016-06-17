<?php

namespace App\Page;

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
        $code      = $this->page->getPageCode($action);
        if (is_null($code)) {
            return "Cannot find Current Web Route!!";
        }
        $WebRoute = '';
        for ($i = 1; $i <= strlen($code); $i += 2) {
            $tmp_code = substr($code, 0, $i);
            $page = Page::where('code', substr($code, 0, $i))
                                 ->first();
            if ($i == strlen($code)) {
                $WebRoute .= $page->name;
            } else {
                //$WebRoute .= '<a href="'.action($page->action).'">';
                $WebRoute .= '<a href="'.action($page->action).'">';
                $WebRoute .= $page->name.'</a>';
            }
            $WebRoute .= ' > ';
        }
        $WebRoute = substr($WebRoute, 0, -3);
        return $WebRoute;
    }

    public function getPageAction(Page $page)
    {
        $action = "";
        if (!empty($page->namespace)) {
            $action .= $page->namespace."\\";
        }

        $action .= $page->action;

        return action($action);
    }
}