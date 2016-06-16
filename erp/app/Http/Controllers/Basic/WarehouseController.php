<?php

namespace App\Http\Basic\Controllers;

use Illuminate\Http\Request;

use App\Repositories\WarehouseRepository;

use App\Http\Requests\ErpRequest;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = WarehouseRepository::getWarehousesOnePage();
        return view('warehouses.index', ['warehouses' => $warehouses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //找出之前輸入的資料
        $warehouse = $request->old('warehouse');
        //if(count($request->old()) > 0) dd($request->old());
        return view('warehouses.create', ['warehouse' => $warehouse]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ErpRequest $request)
    {
        //抓出使用者輸入的資料
        $warehouse = $request->input('warehouse');
        $new_id = WarehouseRepository::storeWarehouse($warehouse);
        return redirect()->action('WarehouseController@show', ['id' => $new_id])
                            ->with('status', [0 => '倉庫資料已新增!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $warehouse = WarehouseRepository::getWarehouseDetail($id);
        return view('warehouses.show', ['id' => $id, 'warehouse' => $warehouse]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if (count($request->old('warehouse')) > 0) {
            $warehouse = $request->old('warehouse');
        } else {
            $warehouse = WarehouseRepository::getWarehouseDetail($id);
        }
        return view('warehouses.edit', ['id' => $id, 'warehouse' => $warehouse]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ErpRequest $request, $id)
    {
        $warehouse = $request->input('warehouse');
        WarehouseRepository::updateWarehouse($warehouse, $id);
        return redirect()->action('WarehouseController@show', ['id' => $id])
                            ->with('status', [0 => '倉庫資料已更新!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        WarehouseRepository::deleteWarehouse($id);
        return redirect()->action('WarehouseController@index')
                            ->with('status', [0 => '倉庫資料已刪除!']);
    }
}
