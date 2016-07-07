<?php

namespace App\Http\Controllers\Purchase;

use App;
use App\Contracts\FormRequestInterface;
use App\Http\Controllers\BasicController;
use App\Repositories\Purchase\PayableWriteOffRepository as OrderRepository;
use App\Services\Purchase\PayableWriteOffService as orderService;
use Illuminate\Http\Request;

class PayableWriteOffController extends BasicController
{
    protected $orderRepository;
    protected $orderService;
    private $orderMasterInputName = 'payableWriteOff';
    private $orderCreditInputName = 'payableWriteOffCredit';
    private $orderDebitInputName = 'payableWriteOffDebit';
    private $routeName = 'purchase.payableWriteOff';
    private $ordersPerPage = 15;
    /**
     * SupplierController constructor.
     *
     * @param SupplierRepository $supplierRepository
     */
    public function __construct(
        OrderRepository $orderRepository,
        OrderService $orderService
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderService    = $orderService;
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
            $this->creditInputName => $request->old($this->creditInputName),
            $this->debitInputName => $request->old($this->debitInputName),
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
        $orderCredit = $request->input($this->creditInputName);
        $orderdebit = $request->input($this->debitInputName);

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
        $orderMaster = $this->orderRepository->getOrderMaster($code);
        $orderMaster->supplier_code = $orderMaster->supplier->code;
        $orderMaster->supplier_name = $orderMaster->supplier->name;

        $orderCredit = $this->orderRepository->getOrderCredit($code);

        $orderDebit = $this->orderRepository->getOrderDebit($code);

        return view($this->routeName.'.show', [
            $this->orderMasterInputName => $orderMaster,
            $this->orderCreditInputName => $orderCredit,
            $this->orderDebitInputName => $orderDebit
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $code)
    {
        if ($request->old($this->orderMasterInputName)) {
            $orderMaster = $request->old($this->orderMasterInputName);
            $orderMaster['created_at'] = $this->orderRepository
                ->getOrderMasterfield('created_at', $code);
            $orderMaster['code'] = $code;
        } else {
            $orderMaster = $this->orderRepository->getOrderMaster($code);
            $orderMaster->supplier_code = $orderMaster->supplier->code;
            $orderMaster->supplier_name = $orderMaster->supplier->name;
        }

        return view($this->routeName.'.edit', [
            $this->orderMasterInputName => $orderMaster,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($code)
    {
        //驗證表單填入的資料
        $request = App::make(
            'App\Contracts\FormRequestInterface',
            ['className' => $this->className]
        );

        $orderMaster = $request->input($this->orderMasterInputName);

        return $this->orderService->update($this, $orderMaster, $code);
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

    public function orderCreated($status, $code)
    {
        return redirect()->action($this->className.'@show', ['code' => $code])
            ->with(['status' => $status]);
    }

    public function orderCreatedErrors($errors)
    {
        return back()->withInput()->withErrors($errors);
    }

    public function orderUpdated($status, $code)
    {
        return redirect()->action($this->className.'@show', ['code' => $code])
            ->with(['status' => $status]);
    }

    public function orderUpdatedErrors($errors)
    {
        return back()->withInput()->withErrors($errors);
    }

    public function orderDeleted($status, $code)
    {
        return redirect()->action($this->className.'@index')->with(['status' => $status]);
    }

    public function orderDeletedErrors($errors)
    {
        return back()->withInput()->withErrors($errors);
    }
}