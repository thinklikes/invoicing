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
        //取得目前執行的路由名稱
        $route_name = $request->route()->getName();

        $result = $request->user()->auth->pages->contains('route_name', $route_name);

        if (preg_match("/(json|printing|printBarcode|printTag)$/", $route_name)) {
            $result = true;
        }

        if ($result) {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
