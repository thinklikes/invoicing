<?php

namespace Supplier;

use App\Repositories\BasicRepository;
use DB;

class SupplierRepository extends BasicRepository
{
    protected $supplier;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }

    /**
     * find 15 suppliers to JSON
     * @return array all suppliers
     */
    public function getSuppliersJson($param)
    {
        return $this->supplier->select('id', 'code', 'shortName','name')
            ->where(function ($query) use($param) {
                if (isset($param['name'])) {
                    $query->orWhere('name', 'like', "%".trim($param['name'])."%");
                }
                if (isset($param['code'])) {
                    $query->orWhere('code', trim($param['code']));
                }
            })
            ->orderBy('id')
            ->skip(0)
            ->take(15)
            ->get();
    }

    /**
     * find One page of suppliers
     * @return array all suppliers
     */
    public function getSuppliersPaginated($param)
    {
        $suppliers = $this->supplier->where(function ($query) use($param) {
            if (isset($param['name']) && $param['name'] != "") {
                $query->orWhere('name', 'like', "%".trim($param['name'])."%");
            }
            if (isset($param['code']) && $param['code'] != "") {
                $query->orWhere('code', 'like', "%".trim($param['code'])."%");
            }
            if (isset($param['address']) && $param['address'] != "") {
                $query->orWhere('address', 'like', "%".trim($param['address'])."%");
            }
        })->paginate(15);
        return $suppliers;
        //$suppliers->setPath('suppliers/test/gogogo');
        //return $suppliers;
    }
    /**
     * find detail of one supplier
     * @param  integer $id The id of supplier
     * @return array       one supplier
     */
    public function getSupplierDetail($id)
    {
        return $this->supplier->find($id);
    }

    /**
     * store a supplier
     * @param  integer $id The id of supplier
     * @return void
     */
    public function storeSupplier($supplier)
    {
        $columns = $this->getTableColumnList($this->supplier);
        $this->supplier = new Supplier;
        foreach($columns as $key) {
            if (isset($supplier[$key])) {
                $this->supplier->{$key} = $supplier[$key];
            }
        }
        $this->supplier->save();
        return $this->supplier->id;
    }

    /**
     * update a supplier
     * @param  integer $id The id of supplier
     * @return void
     */
    public function updateSupplier($supplier, $id)
    {
        $this->supplier = $this->supplier->find($id);
        foreach($supplier as $key => $value) {
            $this->supplier->{$key} = $value;
        }
        $this->supplier->save();
    }

    /**
     * delete a supplier
     * @param  integer $id The id of supplier
     * @return void
     */
    public function deleteSupplier($id)
    {
        $this->supplier = $this->supplier->find($id);
        $this->supplier->delete();
    }
}