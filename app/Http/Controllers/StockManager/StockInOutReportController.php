<?php
namespace App\Http\Controllers\StockManager;

use App;
use StockInOutReport\StockInOutReportService as OrderService;
use App\Http\Controllers\BasicController;
use Illuminate\Http\Request;

class StockInOutReportController extends BasicController
{
    private $orderMasterInputName = 'stockInOutReport';
    private $routeName = 'erp.stockManager.stockInOutReport';
    /**
     * CompanyController constructor.
     *
     * @param CompanyRepository $companyRepository
     */
    public function __construct(
        OrderService $orderService
    ) {
        $this->orderService    = $orderService;
        $this->setFullClassName();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view($this->routeName.'.index', [
            $this->orderMasterInputName => $request->old($this->orderMasterInputName),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function printing(Request $request)
    {
        if ($request->input($this->orderMasterInputName.".stock_id") != '') {
            $stock_id = $request->input($this->orderMasterInputName.".stock_id");
        } else {
            $stock_id = 1;
        }

        $warehouse_id = $request->input($this->orderMasterInputName.".warehouse_id");

        $start_date = $request->input($this->orderMasterInputName.".start_date");

        $end_date = $request->input($this->orderMasterInputName.".end_date");

        return view($this->routeName.'.printing', [
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'data' => $this->orderService->getStockInOutLogsByStockId(
                $stock_id, $warehouse_id, $start_date, $end_date)
        ]);

    }

}
