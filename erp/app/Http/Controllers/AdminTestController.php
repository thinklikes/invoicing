<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App;

use DB;

class AdminTestController extends Controller
{
    public function index()
    {
        $collection = DB::table('erp_options')
        ->select('id')
        ->where('class', 'stock_classes')
        ->get();

        $classes = array();

        foreach ($collection as $value) {
            $classes[] = $value->id;
        }
        //$plucked = $collection->pluck('name');

        dd($classes);
    }
}
