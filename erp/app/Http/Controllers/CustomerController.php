<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\CustomerRepository;

use App\Http\Requests\ErpRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $name    = isset($_GET['name']) ? $_GET['name'] : "";
        $address = isset($_GET['address']) ? $_GET['address'] : "";
        $customers = CustomerRepository::getCustomersOnePage([
            'name'    => $name,
            'address' => $address
        ]);
        return view('customers.index', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //找出之前輸入的資料
        $customer = $request->old('customer');
        //if(count($request->old()) > 0) dd($request->old());
        return view('customers.create', ['customer' => $customer]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ErpRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ErpRequest $request)
    {
        //抓出使用者輸入的資料
        $customer = $request->input('customer');
        $new_id = CustomerRepository::storeCustomer($customer);
        return redirect()->action('CustomerController@show', ['id' => $new_id])
                            ->with('status', [0 => '客戶資料已新增!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = CustomerRepository::getCustomerDetail($id);
        return view('customers.show', ['id' => $id, 'customer' => $customer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if (count($request->old('customer')) > 0) {
            $customer = $request->old('customer');
        } else {
            $customer = CustomerRepository::getCustomerDetail($id);
        }
        return view('customers.edit', ['id' => $id, 'customer' => $customer]);
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
        $customer = $request->input('customer');
        CustomerRepository::updateCustomer($customer, $id);
        return redirect()->action('CustomerController@show', ['id' => $id])
                            ->with('status', [0 => '客戶資料已更新!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CustomerRepository::deleteCustomer($id);
        return redirect()->action('CustomerController@index')
                            ->with('status', [0 => '客戶資料已刪除!']);
    }
}