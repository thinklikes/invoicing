<?php

namespace App\Http\Controllers;

use App;
use App\Contracts\FormRequestInterface;
use App\Http\Requests\DestroyRequest;
use App\Http\Controllers\BasicController;
use Company\CompanyRepository as Repository;
use Company\CompanyService as Service;
use Illuminate\Http\Request;

class CompanyController extends BasicController
{
    protected $orderRepository;
    protected $orderService;
    private $orderMasterInputName = 'company';
    private $routeName = 'erp.basic.company';
    private $ordersPerPage = 15;

    public function __construct(
        Repository $orderRepository,
        Service $orderService)
    {
        $this->middleware('page_auth');
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
        $this->setFullClassName();
    }
    public function printBarcode($id = '')
    {
        if ($id) {
            $companies = collect([
                $this->orderRepository->getCompanyById($id)
            ]);
        } else {
            $companies = $this->orderRepository->getAllCompanies();
        }
        return view($this->routeName.'.printBarcode', [
            'companies' => $companies
        ]);
    }

    public function printTag($id = '')
    {
        if ($id) {
            $companies = collect([
                $this->orderRepository->getCompanyById($id)
            ]);
        } else {
            $companies = $this->orderRepository->getAllCompanies();
        }
        return view($this->routeName.'.printTag', [
            'companies' => $companies
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
        return view($this->routeName.'.index', [
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'company' => $this->orderRepository
                ->getCompanyPaginated(
                    array_except($request->input(), 'page'),
                    $this->ordersPerPage)
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
    public function destroy($code)
    {
        return $this->orderService->delete($this, $code);
    }
}
