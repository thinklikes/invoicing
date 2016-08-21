<?php
namespace App\Http\Controllers\StockManager;

use App;
use App\Contracts\FormRequestInterface;
use App\Http\Requests\DestroyRequest;
use App\Http\Controllers\BasicController;
use StockTransfer\StockTransferService as OrderService;
use Illuminate\Http\Request;


class StockTransferController extends BasicController
{
    protected $service;
    private $headName = 'stockTransferMaster';
    private $bodyName = 'stockTransferDetail';
    private $routeName = 'erp.stockManager.stockTransfer';
    private $countPerPage = 15;
    /**
     * CompanyController constructor.
     *
     * @param CompanyRepository $companyRepository
     */
    public function __construct(
        OrderService $service
    ) {
        $this->middleware('page_auth');
        $this->service    = $service;
        $this->setFullClassName();
    }

    /**
     * 回傳Json格式的資料
     * @param  string $data_mode 資料類型
     * @param  string $code      搜尋的鍵值
     * @return Json            Json格式的資料
     */
    // public function json($data_mode, $code)
    // {
    //     switch ($data_mode) {
    //         case 'getReceivableByCompanyId':
    //             $orderMaster = $this->orderRepository->getReceivableByCompanyId($code);
    //             break;
    //         default:
    //             # code...
    //             break;
    //     }
    //     return response()->json($orderMaster->all());
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->routeName.'.index', [
            'orders' => $this->service->showOrders($this->countPerPage)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $master = $request->old($this->headName);

        $details = $request->old($this->bodyName);

        $data = $this->service->getCreateFormData($master, $details);

        return view($this->routeName.'.create', [
            'new_master_code' => $data['new_master_code'],
            'headName' => $this->headName,
            'bodyName' => $this->bodyName,
            $this->headName => $data['master'],
            $this->bodyName => $data['details'],
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
        $orderMaster = $request->input($this->headName);
        $orderDetail = $request->input($this->bodyName);

        return $this->service->create($this, $orderMaster, $orderDetail);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $data = $this->service->getShowTableData($code);

        return view($this->routeName.'.show', [
            $this->headName => $data['master'],
            $this->bodyName => $data['details'],
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
        $master = $request->old($this->headName);

        $details = $request->old($this->bodyName);

        $data = $this->service->getEditFormData($code, $master, $details);

        return view($this->routeName.'.edit', [
            'headName' => $this->headName,
            'bodyName' => $this->bodyName,
            $this->headName => $data['master'],
            $this->bodyName => $data['details'],
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

        $orderMaster = $request->input($this->headName);
        $orderDetail = $request->input($this->bodyName);

        return $this->service->update($this, $orderMaster, $orderDetail, $code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($code)
    {
        return $this->service->delete($this, $code);
    }

    public function printing($code)
    {
        $data = $this->service->getShowTableData($code);

        return view('erp.purchase.order_printing', [
            'chname' => '調整單',
            'headName' => $this->headName,
            'bodyName' => $this->bodyName,
            $this->headName => $data['master'],
            $this->bodyName => $data['details'],
        ]);
    }
}
