<?php

namespace App\Http\Controllers\Basic;

use Illuminate\Http\Request;
use Supplier\SupplierRepository;
use App\Contracts\FormRequestInterface;
use App\Http\Controllers\BasicController;

class SupplierController extends BasicController
{
    protected $supplierRepository;
    private $routeName = 'erp.basic.supplier';

    /**
     * SupplierController constructor.
     *
     * @param SupplierRepository $supplierRepository
     */
    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
        $this->setFullClassName();
    }
    /**
     * 回傳Json格式的供應商陣列，若有request 'with'，
     * 則將相關的進貨單或進或退回單回傳
     *
     * @return \Illuminate\Http\Response
     */
    public function json(Request $request)
    {
        $param = $request->input();
        $suppliers = $this->supplierRepository->getSuppliersPaginated($param);
        return response()->json($suppliers->all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $suppliers = $this->supplierRepository->getSuppliersPaginated(array_except($request->input(), 'page'));
        //$suppliers = SupplierRepository::getSuppliersOnePage($request->input());
        return view($this->routeName.'.index', ['suppliers' => $suppliers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //找出之前輸入的資料
        $supplier = $request->old('supplier');
        //if(count($request->old()) > 0) dd($request->old());
        return view($this->routeName.'.create', ['supplier' => $supplier]);
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
        $supplier = $request->input('supplier');
        $new_id = $this->supplierRepository->storeSupplier($supplier);
        return redirect()->action("$this->className@show", ['id' => $new_id])
                            ->with('status', [0 => '供應商資料已新增!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = $this->supplierRepository->getSupplierDetail($id);
        return view($this->routeName.'.show', ['id' => $id, 'supplier' => $supplier]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if (count($request->old('supplier')) > 0) {
            $supplier = $request->old('supplier');
        } else {
            $supplier = $this->supplierRepository->getSupplierDetail($id);
        }
        return view($this->routeName.'.edit', ['id' => $id, 'supplier' => $supplier]);
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
        $supplier = $request->input('supplier');
        $this->supplierRepository->updateSupplier($supplier, $id);
        return redirect()->action("$this->className@show", ['id' => $id])
                            ->with('status', [0 => '供應商資料已更新!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->supplierRepository->deleteSupplier($id);
        return redirect()->action("$this->className@index")
                            ->with('status', [0 => '供應商資料已刪除!']);
    }
}
