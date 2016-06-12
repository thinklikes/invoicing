<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\App;

class RequestFactory
{
    /**
     * @param string $method
     */
    public function create($method)
    {
        App::bind(RequestInterface::class,
            'App\Http\Requests\\'.$method);
    }
}