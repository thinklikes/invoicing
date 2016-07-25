<?php

namespace App\Http\Controllers\Basic;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\BasicController;
use Company\CompanyRepository as Repository;

class CompanyController extends BasicController
{
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
        $this->repository->countsPerPage = 20;
    }
    public function json(Request $request)
    {
        $param = $request->input();
        return $this->repository->getCompanyJson($param);
    }
}
