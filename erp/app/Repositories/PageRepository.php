<?php

namespace App\Repositories;

use App\Page;

use Route;

class PageRepository
{
    protected static function getPageCode() {
        //$url = preg_replace('#https?://#', '', $url);
        $CurrentRoute = Route::currentRouteAction();

        $tmp = explode("\\", $CurrentRoute);
        if (count($tmp) >= 1) {
            $action = last($tmp);
        } else {
            $action = '';
        }
        $code = Page::select('code')
                        ->where('action', $action)
                        ->value('code');
        return $code;
    }
    /**
     * 找出網頁上的路徑
     * @return String -包含超連結的路徑
     */
    public static function getCurrentWebRoute()
    {
        $code = self::getPageCode();
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
