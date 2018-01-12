<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests;
use App\Http\Controllers\BasicController;
use Illuminate\Http\Request;
use Erp\Services\ReportServiceInterface as Service;

class ReportController extends BasicController
{
    private $app_name = '';
    private $headName = '';
    private $routeName = '';
    private $viewPath = '';
    /**
     * CompanyController constructor.
     *
     * @param CompanyRepository $companyRepository
     */
    public function __construct(Request $request)
    {
        $this->middleware('page_auth');

        $this->routeName = explode("/", $request->path())[0];

        $this->app_name = $this->routeName;

        $this->className = 'Erp\ReportController';

        $this->service = App::make(
            Service::class,
            ['app_name' => $this->app_name]);

        $this->headName = $this->service->getProperty('headName');

        $this->viewPath = $this->service->getProperty('viewPath');
    }

    /**
     * 此應用程式的index頁面
     * @param  Request $request 上一次輸入的數值
     * @return Response          回應html page給使用者
     */
    public function index(Request $request)
    {
        return view($this->viewPath.'.index', [
            $this->headName => $request->old($this->headName),
            'routeName' => $this->routeName,
            'app_name'  => $this->app_name
        ]);
    }

    /**
     * 此應用程式的列印頁面
     * @param  Request $request 上一次輸入的數值
     * @return Response          回應html page給使用者
     */
    public function printing(Request $request)
    {
        $param = [
            'warehouse_id' => $request->input('warehouse_id'),
            'stock_id' => $request->input('stock_id'),
        ];

        $data = $this->service->getReportData($param);

        $data = $data->groupBy('stock_id')->all();

        $keys = array_keys($data);

        return view($this->viewPath.'.printing', [
            'keys' => $keys,
            'data' => $data,
        ]);
    }
}
