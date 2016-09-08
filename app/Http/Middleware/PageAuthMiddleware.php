<?php

namespace App\Http\Middleware;

use Closure;
use Route;
class PageAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //取得目前執行的控制器方法
        $action = str_replace("App\\Http\\Controllers\\", "",
            $request->route()->getActionName());

        $result = $request->user()->auth->pages->contains('action', $action);

        if (preg_match("/(json|printing|printBarcode|printTag)$/", $action)) {
            $result = true;
        }

        if ($result) {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
