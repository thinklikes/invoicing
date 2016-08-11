<?php

namespace App\Http\Controllers\Basic;

use App;
use App\Contracts\FormRequestInterface;
use App\Http\Requests\DestroyRequest;
use App\Http\Controllers\BasicController;
use Company\CompanyRepository as Repository;
use Company\CompanyService as Service;
use Illuminate\Http\Request;

class CompanyController extends BasicController
{
    private $orderRepository;
    private $orderService;
    private $orderMasterInputName = 'company';
    private $routeName = 'erp.basic.company';
    private $ordersPerPage = 15;
    private $app_name = 'company';
    private $chname = '客戶';

    public function __construct(
        Repository $orderRepository,
        Service $orderService)
    {
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
        $this->setFullClassName();
    }
    public function printBarcode()
    {
        return view($this->routeName.'.printBarcode', [
            'companies' => $this->orderRepository->getAllCompanyNameAndCode()
        ]);
    }

    public function json(Request $request)
    {
        $param = $request->input();
        return $this->orderRepository->getCompanyJson($param);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companies = $this->orderRepository
            ->getCompanyPaginated(
                $request->input('search'),
                $this->ordersPerPage);

        $data = [
            'app_name' => $this->app_name,
            'chname' => $this->chname,
            'sidebar' => [
                'title' => '搜尋',
                'button_text' => '搜尋',
                'item' => [
                    (object)[
                        'title' => '客戶編號',
                        'element' => 'text',
                        'name' => 'search[code]',
                        'value' => $request->input('search')['code']
                    ],
                    (object)[
                        'title' => '公司名稱',
                        'element' => 'text',
                        'name' => 'search[name]',
                        'value' => $request->input('search')['name']
                    ],
                    (object)[
                        'title' => '地址',
                        'element' => 'text',
                        'name' => 'search[address]',
                        'value' => $request->input('search')['address']
                    ],
                ],
            ],
        ];

        $data['master']['item'] = $companies;
        $data['master']['title'] = [
            'company_code' => '客戶編號',
            'company_name' => '公司名稱',
            'company_tel' => '公司電話',
            'company_add' => '公司地址'
        ];
        $data['master']['paginated'] = $companies->render();

        return view('erp.crud_index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view($this->routeName.'.create', [
            $this->orderMasterInputName => $request->old($this->orderMasterInputName),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormRequestInterface $request)
    {
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
    public function show($id)
    {
        $orderMaster = $this->orderRepository->getCompanyById($id);

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
    public function edit(Request $request, $id)
    {
        if ($request->old()) {
            $orderMaster = $request->old($this->orderMasterInputName);

            $orderMaster['auto_id'] = $id;
        } else {
            $orderMaster = $this->orderRepository->getCompanyById($id);

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
    public function update(FormRequestInterface $request, $id)
    {

        $orderMaster = $request->input($this->orderMasterInputName);

        return $this->orderService->update($this, $orderMaster, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRequest $request, $code)
    {
        return $this->orderService->delete($this, $code);
    }
}
