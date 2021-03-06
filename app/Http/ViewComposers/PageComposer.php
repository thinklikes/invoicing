<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Repositories\PageRepository as PageRepository;

class PageComposer
{
    /**
     * Page物件的實例。
     *
     * @var PageRepository
     */
    protected $users;

    /**
     * 建立一個新的個人資料視圖組件。
     *
     * @param  PageRepository  $users
     * @return void
     */
    public function __construct(PageRepository $pages)
    {
        // 所有依賴都會自動地被服務容器解析...
        $this->users = $users;
    }

    /**
     * 將資料綁定到視圖。
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('count', $this->users->count());
    }
}