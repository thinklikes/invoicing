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
    public function getPageCode($namespace, $action)
    {
        return $this->page->select('code')
                ->where('namespace', $namespace)
                ->where('action', $action)
                ->value('code');
    }
}
