<?php

namespace App\Page;

class PagePresenter
{
    protected $page;
    private $basicControllerNamespace = 'App\\Http\\Controllers\\';

    public function __construct(PageRepository $page)
    {
        $this->page = $page;
    }
    private function exceptBasicNamesapce($currentRoute)
    {
        return str_replace($this->basicControllerNamespace, '', $currentRoute);
    }
    private function findAction($currentRoute)
    {
        $currentRoute = $this->exceptBasicNamesapce($currentRoute);
        return last(explode('\\', $currentRoute));
    }
    private function findNamespace($currentRoute)
    {
        $currentRoute = $this->exceptBasicNamesapce($currentRoute);
        $currentRoute = explode('\\', $currentRoute);
        if (count($currentRoute) == 1) {
            return '';
        }
        return $currentRoute[1];
    }
    /**
     * 找出網頁上的路徑
     * @return String -包含超連結的路徑
     */
    public function getCurrentWebRoute($currentRoute)
    {
        if (!is_null($currentRoute)) {
            return Exception("Illegal argument");
        }
        $action = $this->findAction($currentRoute);
        $namespace = $this->findNamespace($currentRoute);


        dd($action);
        //dd(method_exists($this->page, 'getPageCode'));
        $code = $this->page->getPageCode($namespace, $action);

        dd($code);
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

}