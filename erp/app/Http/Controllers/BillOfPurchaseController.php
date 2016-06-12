<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\BillOfPurchaseRepository;

use App\Repositories\WarehouseRepository;

//use App\Http\Requests\ErpRequest;

use App\Http\Requests\RequestFactory;

use App\Http\Requests\RequestInterface;

use App\Providers\BillOfPurchaseServiceProvider;

class BillOfPurchaseController extends Controller
{
    protected $serviceProvider;
    protected $billOfPurchaseRepository;
    protected $warehouseRepository;
    protected $stockWarehouseRepository;
    protected $requestFactory;
    protected $requestMethod = 'BillOfPurchaseRequest';
    /**
     * SupplierController constructor.
     *
     * @param SupplierRepository $supplierRepository
     */
    public function __construct(BillOfPurchaseRepository $billOfPurchaseRepository,
        RequestFactory $requestFactory,
        WarehouseRepository $warehouseRepository,
        BillOfPurchaseServiceProvider $billOfPurchaseServiceProvider)
    {
        $this->billOfPurchaseRepository = $billOfPurchaseRepository;
        $this->requestFactory           = $requestFactory;
        $this->warehouseRepository      = $warehouseRepository;
        $this->requestFactory->create($this->requestMethod);
        $this->serviceProvider = $billOfPurchaseServiceProvider;
        //$this->stockWarehouseRepository = $this->app->make('StockWarehouseRepository');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billsOfPurchase = $this->billOfPurchaseRepository->getBillOfPurchasesOnePage();
        return view('billsOfPurchase.index', ['billsOfPurchase' => $billsOfPurchase]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //找出之前輸入的資料
        $billOfPurchase = array();
        $billOfPurchase['master'] = $request->old('billOfPurchaseMaster');
        $billOfPurchase['detail'] = $request->old('billOfPurchaseDetail');

        //抓出倉庫名稱陣列
        $warehousesPair = $this->warehouseRepository->getAllWarehousesPair();

        //抓出新單號
        $new_master_code = $this->billOfPurchaseRepository->getNewMasterCode();
        return view('billsOfPurchase.create', [
            'warehousesPair'       => $warehousesPair,
            'new_master_code'      => $new_master_code,
            'billOfPurchaseMaster' => $billOfPurchase['master'],
            'billOfPurchaseDetail' => $billOfPurchase['detail'],
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
        $billOfPurchaseMaster = $request->input('billOfPurchaseMaster');
        $billOfPurchaseDetail = $request->input('billOfPurchaseDetail');

        $code = $billOfPurchaseMaster['code'];

        $this->billOfPurchaseRepository->storeBillOfPurchaseMaster($billOfPurchaseMaster);

        foreach($billOfPurchaseDetail as $key => $value) {
            if ($value['quantity'] == 0 || $value['quantity'] == "") {
                continue;
            }
            $this->billOfPurchaseRepository->storeBillOfPurchaseDetail(
                $value, $code
            );
        }
        return redirect()->action(
                'BillOfPurchaseController@show',
                ['code' => $code]
            )->with('status', [0 => '進貨單已新增!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $billOfPurchase = $this->billOfPurchaseRepository->getBillOfPurchaseDetail($code);

        $billOfPurchase['master']->supplier_code
            = $billOfPurchase['master']->supplier->code;

        $billOfPurchase['master']->supplier_name
            = $billOfPurchase['master']->supplier->name;

        foreach ($billOfPurchase['detail'] as $key => $value) {
            $billOfPurchase['detail'][$key]->stock_code
                = $billOfPurchase['detail'][$key]->stock->code;

            $billOfPurchase['detail'][$key]->stock_name
                = $billOfPurchase['detail'][$key]->stock->name;

            $billOfPurchase['detail'][$key]->unit
                = $billOfPurchase['detail'][$key]->stock->unit->comment;
        }
        return view('billsOfPurchase.show', [
            'code'                  => $code,
            'billOfPurchaseMaster' => $billOfPurchase['master'],
            'billOfPurchaseDetail' => $billOfPurchase['detail'],
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
        if (count($request->old('billOfPurchaseMaster')) > 0 ||
            $request->old('billOfPurchaseDetail') > 0)
        {
            $billOfPurchase = array();
            $billOfPurchase['master'] = $request->old('billOfPurchaseMaster');
            $billOfPurchase['detail'] = $request->old('billOfPurchaseDetail');
        } else {
            $billOfPurchase = $this->billOfPurchaseRepository
                ->getBillOfPurchaseDetail($code);

            $billOfPurchase['master']->supplier_code
                = $billOfPurchase['master']->supplier->code;

            $billOfPurchase['master']->supplier_name
                = $billOfPurchase['master']->supplier->name;

            foreach ($billOfPurchase['detail'] as $key => $value) {
                $billOfPurchase['detail'][$key]->stock_code
                    = $billOfPurchase['detail'][$key]->stock->code;

                $billOfPurchase['detail'][$key]->stock_name
                    = $billOfPurchase['detail'][$key]->stock->name;

                $billOfPurchase['detail'][$key]->unit
                    = $billOfPurchase['detail'][$key]->stock->unit->comment;
            }
        }

        //抓出倉庫名稱陣列
        $warehousesPair = $this->warehouseRepository->getAllWarehousesPair();

        return view('billsOfPurchase.edit', [
            'code'                  => $code,
            'warehousesPair'       => $warehousesPair,
            'billOfPurchaseMaster' => $billOfPurchase['master'],
            'billOfPurchaseDetail' => $billOfPurchase['detail'],
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
        $billOfPurchase = array();
        $billOfPurchaseMaster = $request->input('billOfPurchaseMaster');
        $billOfPurchaseDetail = $request->input('billOfPurchaseDetail');

        //先存入表頭
        $this->billOfPurchaseRepository->updateBillOfPurchaseMaster(
            $billOfPurchaseMaster, $code
        );

        //清空表身
        $this->billOfPurchaseRepository->clearBillOfPurchaseDetail($code);

        foreach ($billOfPurchaseDetail as $key => $value) {
            if ($value['quantity'] == 0 || $value['quantity'] == "") {
                continue;
            }
            $this->billOfPurchaseRepository->updateBillOfPurchaseDetail(
                $value, $code
            );
        }
        return redirect()->action('BillOfPurchaseController@show', ['code' => $code])
                            ->with('status', [0 => '進貨單已更新!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($code)
    {
        $this->billOfPurchaseRepository->deleteBillOfPurchase($code);
        return redirect()->action('BillOfPurchaseController@index')
                            ->with('status', [0 => '進貨單已刪除!']);
    }
}
