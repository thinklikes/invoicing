<?php

namespace Company;

use App;
use App\Repositories\BasicRepository;
use Company\Company;

class CompanyRepository extends BasicRepository
{
    public $countsPerPage = 15;
    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(Company $company)
    {
        $this->mainModel = $company;
    }

    /**
     * find 15 company to JSON
     * @return array all company
     */
    public function getCompanyJson($param)
    {
        return $this->mainModel
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
        return $this->mainModel
            ->where('auto_id', $id)
            ->firstOrFail();
    }

    /**
     * find a page of orders
     * @return array all purchases
     */
    public function getCompanyPaginated($param, $ordersPerPage)
    {
        return $this->mainModel->where(function ($query) use($param) {
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
        return $this->mainModel->where('auto_id', $id)->value($field);
    }

    /**
     * 取得所有的客戶
     * @param  array  $param 過濾的參數，只顯示陣列所帶的欄位
     * @return [type]        [description]
     */
    public function getAllCompanies()
    {
        return $this->mainModel->orderBy('auto_id', 'desc')->get();
    }

    /**
     * store billOfPurchaseMaster
     * @param  Array billOfPurchaseMaster
     * @return boolean
     */
    public function storeCompany($company)
    {
        $columnsOfMaster = $this->getTableColumnList($this->mainModel);
        $mainModel = $this->getNew();
        //判斷request傳來的欄位是否存在，有才存入此欄位數值
        $mainModel->fill($company);
        //開始存入表頭
        return [$mainModel->save(), $mainModel->auto_id];
    }

    /**
     * update billOfPurchaseMaster
     * @param  integer $id The id of purchase
     * @return void
     */
    public function updateCompany($company, $id)
    {
        $columnsOfMaster = $this->getTableColumnList($this->mainModel);

        $this->mainModel = $this->mainModel
            ->where('auto_id', $id)
            ->first();

        //有這個欄位才存入
        foreach($columnsOfMaster as $key) {
            if (isset($company[$key])) {
                $this->mainModel->{$key} = $company[$key];
            }
        }
        //$this->mainModel->code = $code;
        //開始存入表頭
        return $this->mainModel->save();
    }

    /**
     * delete a Purchase
     * @param  integer $id The id of purchase
     * @return void
     */
    public function deleteCompany($id)
    {
        return $this->mainModel
            ->where('auto_id', $id)
            ->first()
            ->delete();
    }

    /**
     * 檢查電商平台上傳的內容，其中的客戶是否有存在
     * @param  arrray $dataRow 電商平台文件中的一個excel row
     * @return boolean 是否已有這個客戶
     */
    public function checkCompanyExistsForB2C($dataRow)
    {
        $company = $this->mainModel->where('company_name', '=', $dataRow['company_name'])
            ->where('company_tel', '=', $dataRow['company_tel'])
            ->where('company_add', '=', $dataRow['company_add'])
            ->first();

        return $company ? $company : false;
    }
}