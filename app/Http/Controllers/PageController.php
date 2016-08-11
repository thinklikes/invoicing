<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Page\PageService as Service;
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

        return redirect('/erp');
    }
    public function index(Request $request)
    {
        return view('home', ['pages' => $this->service->getSubPagesOfIndex($request)]);
    }
    public function basic(Request $request)
    {
        return view('home', ['pages' => $this->service->getSubPagesOfSubIndex($request, "basic")]);
    }

    public function purchase(Request $request)
    {
        return view('home', ['pages' => $this->service->getSubPagesOfSubIndex($request, "purchase")]);
    }

    public function sale(Request $request)
    {
        return view('home', ['pages' => $this->service->getSubPagesOfSubIndex($request, "sale")]);
    }

    public function stockManager(Request $request)
    {
        return view('home', ['pages' => $this->service->getSubPagesOfSubIndex($request, "stockManager")]);
    }

    public function system(Request $request)
    {
        return view('home', ['pages' => $this->service->getSubPagesOfSubIndex($request, "system")]);
    }
}
