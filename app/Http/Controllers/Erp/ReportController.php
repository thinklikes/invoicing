<?php

namespace App\Http\Controllers\Erp;

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

    public function index(Request $request)
    {
        return view($this->viewPath.'.index', [
            $this->headName => $request->old($this->headName),
            'routeName' => $this->routeName,
            'app_name'  => $this->app_name
        ]);
    }
}
