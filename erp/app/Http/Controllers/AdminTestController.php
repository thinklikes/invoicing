<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App;

class AdminTestController extends Controller
{
    public function index()
    {
        dd(config('system_configs'));
    }
}
