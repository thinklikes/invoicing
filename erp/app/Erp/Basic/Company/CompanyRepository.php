<?php

namespace Company;

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
        return $this->company->select('auto_id', 'company_abb','company_name')
            ->where(function ($query) use($param) {
                if (isset($param['name'])) {
                    $query->orWhere('company_name', 'like', "%".trim($param['name'])."%");
                }
                // if (isset($param['code'])) {
                //     $query->orWhere('code', trim($param['code']));
                // }
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
     * find One page of suppliers
     * @return array all suppliers
     */
    // public function getCompanyPaginated($param)
    // {
    //     return $this->company->select('auto_id', 'company_abb','company_name')
    //         ->where(function ($query) use($param) {
    //             if (isset($param['name']) && $param['name'] != "") {
    //                 $query->orWhere('company_name', 'like', "%".trim($param['name'])."%");
    //             }
    //             // if (isset($param['code']) && $param['code'] != "") {
    //             //     $query->orWhere('code', 'like', "%".trim($param['code'])."%");
    //             // }
    //             if (isset($param['address']) && $param['address'] != "") {
    //                 $query->orWhere('company_add', 'like', "%".trim($param['address'])."%");
    //             }
    //         })->paginate(15);
    // }
    /**
     * find detail of one supplier
     * @param  integer $id The id of supplier
     * @return array       one supplier
     */
    // public function getCompanyDetail($id)
    // {
    //     return $this->company->where('auto_id', $id)->first();
    // }
}