<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\PurchaseOrderRepository;

//use Validator;

//use App\Http\Requests\ErpRequest;

use App\Http\Requests\RequestFactory;

use App\Http\Requests\RequestInterface;

class PurchaseOrderController extends Controller
{
    protected $purchaseOrderRepository;
    protected $requestFactory;
    protected $requestMethod = 'PurchaseOrderRequest';
    /**
     * SupplierController constructor.
     *
     * @param SupplierRepository $supplierRepository
     */
    public function __construct(PurchaseOrderRepository $purchaseOrderRepository,
        RequestFactory $requestFactory)
    {
        $this->purchaseOrderRepository = $purchaseOrderRepository;
        $this->requestFactory          = $requestFactory;

        $this->requestFactory->create($this->requestMethod);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchase_orders = $this->purchaseOrderRepository->getPurchaseOrdersOnePage();
        return view('purchase_orders.index', ['purchase_orders' => $purchase_orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //找出之前輸入的資料
        $purchase_order = array();
        $purchase_order['master'] = $request->old('purchase_order_master');
        $purchase_order['detail'] = $request->old('purchase_order_detail');

        //抓出新單號
        $new_master_code = $this->purchaseOrderRepository->getNewMasterCode();
        return view('purchase_orders.create', [
            'new_master_code'       => $new_master_code,
            'purchase_order_master' => $purchase_order['master'],
            'purchase_order_detail' => $purchase_order['detail'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestInterface $request)
    {
        //抓出使用者輸入的資料，並排除一些不需要的資訊
        $purchase_order = array();
        $purchase_order['master'] = $request->input('purchase_order_master');
        $purchase_order['detail'] = $request->input('purchase_order_detail');

        $new_code = $this->purchaseOrderRepository->storePurchaseOrder($purchase_order);
        return redirect()->action('PurchaseOrderController@show', ['code' => $new_code])
                            ->with('status', [0 => '採購單已新增!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $purchase_order = $this->purchaseOrderRepository->getPurchaseOrderDetail($code);

        $purchase_order['master']->supplier_code
            = $purchase_order['master']->supplier->code;

        $purchase_order['master']->supplier_name
            = $purchase_order['master']->supplier->name;

        foreach ($purchase_order['detail'] as $key => $value) {
            $purchase_order['detail'][$key]->stock_code
                = $purchase_order['detail'][$key]->stock->code;

            $purchase_order['detail'][$key]->stock_name
                = $purchase_order['detail'][$key]->stock->name;

            $purchase_order['detail'][$key]->unit
                = $purchase_order['detail'][$key]->stock->unit->comment;
        }
        return view('purchase_orders.show', [
            'code'                  => $code,
            'purchase_order_master' => $purchase_order['master'],
            'purchase_order_detail' => $purchase_order['detail'],
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
        if (count($request->old('purchase_order_master')) > 0 ||
            $request->old('purchase_order_detail') > 0)
        {
            $purchase_order = array();
            $purchase_order['master'] = $request->old('purchase_order_master');
            $purchase_order['detail'] = $request->old('purchase_order_detail');
        } else {
            $purchase_order = $this->purchaseOrderRepository
                ->getPurchaseOrderDetail($code);

            $purchase_order['master']->supplier_code
                = $purchase_order['master']->supplier->code;

            $purchase_order['master']->supplier_name
                = $purchase_order['master']->supplier->name;

            foreach ($purchase_order['detail'] as $key => $value) {
                $purchase_order['detail'][$key]->stock_code
                    = $purchase_order['detail'][$key]->stock->code;

                $purchase_order['detail'][$key]->stock_name
                    = $purchase_order['detail'][$key]->stock->name;

                $purchase_order['detail'][$key]->unit
                    = $purchase_order['detail'][$key]->stock->unit->comment;
            }

        }
        return view('purchase_orders.edit', [
            'code'                  => $code,
            'purchase_order_master' => $purchase_order['master'],
            'purchase_order_detail' => $purchase_order['detail'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestInterface $request, $code)
    {
        $purchase_order = array();
        $purchase_order['master'] = $request->input('purchase_order_master');
        $purchase_order['detail'] = $request->input('purchase_order_detail');

        $this->purchaseOrderRepository->updatePurchaseOrder($purchase_order, $code);
        return redirect()->action('PurchaseOrderController@show', ['code' => $code])
                            ->with('status', [0 => '採購單已更新!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($code)
    {
        $this->purchaseOrderRepository->deletePurchaseOrder($code);
        return redirect()->action('PurchaseOrderController@index')
                            ->with('status', [0 => '採購單已刪除!']);
    }
}
