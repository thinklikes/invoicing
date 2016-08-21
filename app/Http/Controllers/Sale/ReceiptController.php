<?php

namespace App\Http\Controllers\Sale;

use App;
use App\Contracts\FormRequestInterface;
use App\Http\Requests\DestroyRequest;
use App\Http\Controllers\BasicController;
use Receipt\ReceiptRepository as OrderRepository;
use Receipt\ReceiptService as OrderService;
use Illuminate\Http\Request;

class ReceiptController extends BasicController
{
    protected $orderRepository;
    protected $orderService;
    private $orderMasterInputName = 'receipt';
    private $routeName = 'erp.sale.receipt';
    private $ordersPerPage = 15;
    /**
     * CompanyController constructor.
     *
     * @param CompanyRepository $companyRepository
     */
    public function __construct(
        OrderRepository $orderRepository,
        OrderService $orderService
    ) {
        $this->middleware('page_auth');
        $this->orderRepository = $orderRepository;
        $this->orderService    = $orderService;
        $this->setFullClassName();
    }

    /**
     * 回傳Json格式的資料
     * @param  string $data_mode 資料類型
     * @param  string $code      搜尋的鍵值
     * @return Json            Json格式的資料
     */
    public function json($data_mode, $code)
    {
        switch ($data_mode) {
            case 'getReceiptByCompanyId':
                $orderMaster = $this->orderRepository->getReceiptByCompanyId($code);
                break;
            default:
                # code...
                break;
        }
        return response()->json($orderMaster->all());
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
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //驗證表單填入的資料
        $request = App::make(
            'App\Contracts\FormRequestInterface',
            ['className' => $this->className]
        );

        //抓出使用者輸入的資料
        $orderMaster = $request->input($this->orderMasterInputName);

        return $this->orderService->create($this, $orderMaster);
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

        return view($this->routeName.'.show', [
            $this->orderMasterInputName => $orderMaster
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
        if ($request->old()) {
            $orderMaster = $request->old($this->orderMasterInputName);

            $orderMaster['created_at'] = $this->orderRepository
                ->getOrderMasterfield('created_at', $code);

            $orderMaster['code'] = $code;
        } else {
            $orderMaster = $this->orderRepository->getOrderMaster($code);

            $orderMaster->company_code = $orderMaster->company->company_code;

            $orderMaster->company_name = $orderMaster->company->company_name;
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
}