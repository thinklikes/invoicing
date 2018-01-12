<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Services\PageService as Service;
use Gate;
use Auth;

class PageController extends Controller
{
    private $service;
    /**
     * 建立一個新的控制器實例。
     *
     * @return void
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function portal()
    {
        if (env('TOP_MENU_ENABLED') == 1) {
            //記錄到PHP session給CRM
            session_start();
            $_SESSION['MM_Username'] = Auth::user()->name;
            return view('portal');
        }

        return redirect('/menu/erp');
    }
    /**
     * show出菜單
     * @param  Request $request 使用者的請求
     * @return Response           回應的頁面
     */
    public function menu(Request $request)
    {
        $method = \Route::current()->getName();

        return view('home', [
            'pages' => $this->service->getSubPagesByUser($request->user(), $method)
        ]);
    }
}
