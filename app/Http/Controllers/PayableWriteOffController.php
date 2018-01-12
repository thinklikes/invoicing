<?php

namespace App\Http\Controllers;

use App;
use App\Contracts\FormRequestInterface;
use App\Http\Requests\DestroyRequest;
use App\Http\Controllers\BasicController;
use PayableWriteOff\PayableWriteOffRepository as OrderRepository;
use PayableWriteOff\PayableWriteOffService as OrderService;
use Payment\PaymentRepository as Payment;
use BillOfPurchase\BillOfPurchaseRepository as BillOfPurchase;
use ReturnOfPurchase\ReturnOfPurchaseRepository as ReturnOfPurchase;

use Illuminate\Http\Request;

class PayableWriteOffController extends BasicController
{
    protected $orderRepository;
    protected $orderService;
    protected $payment;
    protected $billOfPurchase;
    protected $returnOfPurchase;
    private $orderMasterInputName = 'payableWriteOff';
    private $orderCreditInputName = 'payableWriteOffCredit';
    private $orderDebitInputName = 'payableWriteOffDebit';
    private $routeName = 'erp.purchase.payableWriteOff';
    private $ordersPerPage = 15;
    /**
     * SupplierController constructor.
     *
     * @param SupplierRepository $supplierRepository
     */
    public function __construct(
        OrderRepository $orderRepository,
        OrderService $orderService,
        Payment $payment,
        BillOfPurchase $billOfPurchase,
        ReturnOfPurchase $returnOfPurchase
    ) {
        $this->middleware('page_auth');
        $this->orderRepository = $orderRepository;
        $this->orderService    = $orderService;
        $this->payment = $payment;
        $this->billOfPurchase = $billOfPurchase;
        $this->returnOfPurchase = $returnOfPurchase;
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