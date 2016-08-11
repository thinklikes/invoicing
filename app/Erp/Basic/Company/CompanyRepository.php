<?php

namespace Company;

use App;
use App\Repositories\BasicRepository;
use DB;

class CompanyRepository extends BasicRepository
{
    protected $company;

    public $countsPerPage = 15;
    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * find 15 company to JSON
     * @return array all company
     */
    public function getCompanyJson($param)
    {
        return $this->company
            ->select('auto_id', 'company_code', 'company_abb', 'company_name')
            ->where(function ($query) use($param) {
                if (isset($param['name'])) {
                    $query->orWhere(
                        'company_name', 'like', "%".trim($param['name'])."%");
                }
                if (isset($param['code'])) {
                    $query->orWhere(
                        'company_code', '=', trim($param['code']));
                }
            })
            ->orderBy('auto_id')
            ->skip(0)
            ->take($this->countsPerPage)
            ->get();
    }

    public function getCompanyById($id)
    {
        return $this->company
            ->where('auto_id', $id)
            ->firstOrFail();
    }

    /**
     * find a page of orders
     * @return array all purchases
     */
    public function getCompanyPaginated($param, $ordersPerPage)
    {
        return $this->company->where(function ($query) use($param) {
            if (isset($param['name']) && $param['name'] != "") {
                $query->orWhere('company_name', 'like', "%".trim($param['name'])."%");
            }
            if (isset($param['code']) && $param['code'] != "") {
                $query->orWhere('company_code', 'like', "%".trim($param['code'])."%");
            }
            if (isset($param['address']) && $param['address'] != "") {
                $query->orWhere('company_add', 'like', "%".trim($param['address'])."%");
            }
        })
        ->orderBy('auto_id', 'desc')
        ->paginate($ordersPerPage);
    }

    public function getCompanyfieldById($field, $id)
    {
        return $this->company->where('auto_id', $id)->value($field);
    }

    /**
     * 取得所有的客戶編號與名稱
     * @return collection     內容是Company\Company的集合
     */
    public function getAllCompanyNameAndCode()
    {
        return $this->company
            ->select('company_code', 'company_name')
            ->orderBy('auto_id', 'desc')->get();
    }

    /**
     * store billOfPurchaseMaster
     * @param  Array billOfPurchaseMaster
     * @return boolean
     */
    public function storeCompany($company)
    {
        $columnsOfMaster = $this->getTableColumnList($this->company);
        $this->company = App::make('Company\Company');
        //判斷request傳來的欄位是否存在，有才存入此欄位數值
        foreach($columnsOfMaster as $key) {
            if (isset($company[$key])) {
                $this->company->{$key} = $company[$key];
            }
        }

        //開始存入表頭
        return [$this->company->save(), $this->company->auto_id];
    }

    /**
     * update billOfPurchaseMaster
     * @param  integer $id The id of purchase
     * @return void
     */
    public function updateCompany($company, $id)
    {
        $columnsOfMaster = $this->getTableColumnList($this->company);

        $this->company = $this->company
            ->where('auto_id', $id)
            ->first();

        //有這個欄位才存入
        foreach($columnsOfMaster as $key) {
            if (isset($company[$key])) {
                $this->company->{$key} = $company[$key];
            }
        }
        //$this->company->code = $code;
        //開始存入表頭
        return $this->company->save();
    }

    /**
     * delete a Purchase
     * @param  integer $id The id of purchase
     * @return void
     */
    public function deleteCompany($id)
    {
        return $this->company
            ->where('auto_id', $id)
            ->first()
            ->delete();
    }
}