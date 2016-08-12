<?php

namespace App\Http\Controllers\Sale;

use Illuminate\Http\Request;
use App\Http\Controllers\BasicController;
use App\Http\Requests;
use SaleReport\SaleReportService as OrderService;

class SaleReportController extends BasicController
{
    // protected $orderRepository;
    // protected $orderService;
    private $orderMasterInputName = 'saleReport';
    // private $orderDetailInputName = 'returnOfSaleDetail';
    private $routeName = 'erp.sale.saleReport';
    //private $ordersPerPage = 15;

    public function __construct(
        OrderService $orderService)
    {
        $this->orderService    = $orderService;
        // $this->setFullClassName();
    }

    public function index(Request $request)
    {
        return view($this->routeName.".index", [
            $this->orderMasterInputName => $request->old($this->orderMasterInputName)
        ]);
    }

    public function printing(Request $request)
    {
        $company_id = $request->input('saleReport')['company_id'];
        $stock_id = $request->input('saleReport')['stock_id'];
        $start_date = $request->input('saleReport')['start_date'];//string
        $end_date = $request->input('saleReport')['end_date'];//string
        //抓出所有的銷貨退資料
        $data = $this->orderService->getSaleReportByConditions(
            $company_id, $stock_id, $start_date, $end_date);
        //把資料中的company_id 提取出來做為新資料陣列的key
        $data = $data->groupBy('company_id')->all();
        //把keys提取出來為陣列
        $keys = array_keys($data);
        sort($keys);

        return view($this->routeName.".printing", [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'keys' => $keys,
            'data' => $data,
        ]);
    }
}
