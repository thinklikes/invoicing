<?php

namespace App\Http\Controllers\Sale;

use App;
use App\Contracts\FormRequestInterface;
use App\Http\Requests\DestroyRequest;
use App\Http\Controllers\BasicController;
use ReceivableWriteOff\ReceivableWriteOffRepository as OrderRepository;
use ReceivableWriteOff\ReceivableWriteOffService as OrderService;
use Receipt\ReceiptRepository as Receipt;
use BillOfSale\BillOfSaleRepository as BillOfSale;
use ReturnOfSale\ReturnOfSaleRepository as ReturnOfSale;

use Illuminate\Http\Request;

class ReceivableWriteOffController extends BasicController
{
    protected $orderRepository;
    protected $orderService;
    protected $receipt;
    protected $billOfSale;
    protected $returnOfSale;
    private $orderMasterInputName = 'receivableWriteOff';
    private $orderCreditInputName = 'receivableWriteOffCredit';
    private $orderDebitInputName = 'receivableWriteOffDebit';
    private $routeName = 'erp.sale.receivableWriteOff';
    private $ordersPerPage = 15;
    /**
     * SupplierController constructor.
     *
     * @param SupplierRepository $companyRepository
     */
    public function __construct(
        OrderRepository $orderRepository,
        OrderService $orderService,
        Receipt $receipt,
        BillOfSale $billOfSale,
        ReturnOfSale $returnOfSale
    ) {
        $this->middleware('page_auth');
        $this->orderRepository = $orderRepository;
        $this->orderService    = $orderService;
        $this->receipt = $receipt;
        $this->billOfSale = $billOfSale;
        $this->returnOfSale = $returnOfSale;
        $this->setFullClassName();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->routeName.'.index', [
            'orders' => $this->orderRepository->getOrdersPaginated($this->ordersPerPage)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // if ($request->old()) {
        //     dd($request->old($this->orderDebitInputName));
        // }
        return view($this->routeName.'.create', [
            'new_master_code'           => $this->orderRepository->getNewOrderCode(),
            $this->orderMasterInputName => $request->old($this->orderMasterInputName),
            $this->orderCreditInputName => $request->old($this->orderCreditInputName),
            $this->orderDebitInputName => $request->old($this->orderDebitInputName),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //驗證表單填入的資料
        $request = App::make(
            'App\Contracts\FormRequestInterface',
            ['className' => $this->className]
        );

        //抓出使用者輸入的資料
        $orderMaster = $request->input($this->orderMasterInputName);
        $orderCredit = $request->input($this->orderCreditInputName);
        $orderdebit = $request->input($this->orderDebitInputName);

        return $this->orderService->create($this, $orderMaster, $orderCredit, $orderdebit);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        return view($this->routeName.'.show', [
            $this->orderMasterInputName => $this->orderRepository->getOrderMaster($code),
            $this->orderCreditInputName => $this->orderRepository->getOrderCredit($code),
            $this->orderDebitInputName => $this->orderRepository->getOrderDebit($code)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($code)
    {
        return $this->orderService->delete($this, $code);
    }
}