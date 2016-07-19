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
    private $ordersPerPage = 15;
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
    public function print(Request $request)
    {
        if ($request->input($this->orderMasterInputName.".stock_id")) {
            $stock_id = $request->input($this->orderMasterInputName.".stock_id");
        } else {
            $stock_id = 1;
        }
        return $this->orderService->getStockInOutRecordsInDateRange($stock_id   );
        // $orderMaster = $this->orderRepository->getOrderMaster($code);
        // //$orderMaster->company_code = $orderMaster->company->code;

        // $orderDetail = $this->orderRepository->getOrderDetail($code);
        // foreach ($orderDetail as $key => $value) {
        //     $orderDetail[$key]->stock_code = $orderDetail[$key]->stock->code;
        //     $orderDetail[$key]->stock_name = $orderDetail[$key]->stock->name;
        //     $orderDetail[$key]->unit = $orderDetail[$key]->stock->unit->comment;
        // }
        // return view($this->routeName.'.show', [
        //     $this->orderMasterInputName => $orderMaster,
        //     $this->orderDetailInputName => $orderDetail,
        // ]);
    }

}
