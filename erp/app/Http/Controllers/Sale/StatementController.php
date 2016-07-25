<?php

namespace App\Http\Controllers\Sale;

use Illuminate\Http\Request;
use App\Http\Controllers\BasicController;
use App\Http\Requests;

class StatementController extends BasicController
{
    // protected $orderRepository;
    // protected $orderService;
    private $orderMasterInputName = 'statement';
    // private $orderDetailInputName = 'returnOfSaleDetail';
    private $routeName = 'erp.sale.statement';
    //private $ordersPerPage = 15;

    public function __construct()
        //OrderService $orderService)
    {
        // $this->orderService    = $orderService;
        // $this->setFullClassName();
    }

    public function index(Request $request)
    {
        return view($this->routeName.".index", [
            $this->orderMasterInputName => $request->old($this->orderMasterInputName)
        ]);
    }

    public function printing()
    {
        # code...
    }
}
