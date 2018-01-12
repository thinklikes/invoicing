<?php
namespace App\Http\Controllers;

use App;
use StockInOutReport\StockInOutReportService as OrderService;
use App\Http\Controllers\BasicController;
use Illuminate\Http\Request;
use Excel;
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

        $stock_id = $request->input($this->orderMasterInputName.".stock_id");

        $warehouse_id = $request->input($this->orderMasterInputName.".warehouse_id");

        $start_date = $request->input($this->orderMasterInputName.".start_date");

        $end_date = $request->input($this->orderMasterInputName.".end_date");

        $data = $this->orderService->getStockInOutLogsByStockId(
            $stock_id, $warehouse_id, $start_date, $end_date);

        $data = $data->groupBy('stock_id')->all();

        $keys = array_keys($data);

        //判定uri，若不是下載excel，則進入列印畫面
        if (!$request->is('stockInOutReport/excel')) {
            return view($this->routeName.".printing", [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'keys' => $keys,
                'data' => $data,
            ]);
        } else {
            Excel::create($this->routeName, function($excel) use (
                $start_date, $end_date, $keys, $data)
            {

                $excel->sheet('庫存異動表', function($sheet) use (
                    $start_date, $end_date, $keys, $data)
                {

                    $sheet->loadView($this->routeName.".printing",
                        [
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'keys' => $keys,
                            'data' => $data,
                        ]
                    );

                });

            })->export('xls');
        }

    }

}
