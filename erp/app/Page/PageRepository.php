<?php

namespace App\Page;

use App\Page\Page;

class PageRepository
{
    protected $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }
    public function getPageCode($action)
    {
        if (empty($action)) {
            return null;
        }
        return $this->page->select('code')
            ->where('action', $action)
            ->value('code');
    }
}
