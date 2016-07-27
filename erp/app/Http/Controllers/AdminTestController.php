<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App;

use StockInOutReport\StockInOutReportPresenter as OrderTest;

class AdminTestController extends Controller
{
    private $test;

    public function __construct(OrderTest $orderTest)
    {
        $this->test = $orderTest;
    }

    public function index()
    {
        $a = App::make('Statement\StatementService');
        return $a->findCompanyByCompanyId(1)->company_name;
    }
}
