<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Page\Page;

use Auth;

class PageController extends Controller
{
    /**
     * 建立一個新的控制器實例。
     *
     * @return void
     */
    public function __construct()
    {
        session_start();
        $_SESSION['MM_Username'] = Auth::user()->name;
    }
    public function portal()
    {
        return view('portal');
    }
    public function index()
    {
        $pages = Page::where('level', 1)
            ->where('enabled', 1)
            ->get();
        return view('home', ['pages' => $pages]);
    }
    public function basic()
    {
        $parent_code = Page::where('action', 'PageController@basic')->value('code');
        $pages = Page::where('level', 2)
            ->where('enabled', 1)
            ->where('code', 'like', $parent_code.'%')
            ->get();
        return view('home', ['pages' => $pages]);
    }
    public function purchase()
    {
        $parent_code = Page::where('action', 'PageController@purchase')->value('code');
        $pages = Page::where('level', 2)
            ->where('enabled', 1)
            ->where('code', 'like', $parent_code.'%')
            ->get();
        return view('home', ['pages' => $pages]);
    }
    public function sale()
    {
        $parent_code = Page::where('action', 'PageController@sale')->value('code');
        $pages = Page::where('level', 2)
            ->where('enabled', 1)
            ->where('code', 'like', $parent_code.'%')
            ->get();
        return view('home', ['pages' => $pages]);
    }
}
