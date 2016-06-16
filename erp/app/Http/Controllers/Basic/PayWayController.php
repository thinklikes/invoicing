<?php

namespace App\Http\Basic\Controllers;

use Illuminate\Http\Request;

use App\Repositories\OptionRepository;

use App\Http\Requests\ErpRequest;

class PayWayController extends Controller
{
    private $option_class = 'pay_ways';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pay_ways = OptionRepository::getOptionsOnePage($this->option_class);
        return view('pay_ways.index', ['pay_ways' => $pay_ways]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //找出之前輸入的資料
        $pay_way = $request->old('pay_way');
        //if(count($request->old()) > 0) dd($request->old());
        return view('pay_ways.create', ['pay_way' => $pay_way]);
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
        $pay_way = $request->input('pay_way');
        $new_id = OptionRepository::storeOption($this->option_class, $pay_way);
        return redirect()->action('PayWayController@show', ['id' => $new_id])
                            ->with('status', [0 => '單位資料已新增!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pay_way = OptionRepository::getOptionDetail($this->option_class, $id);
        return view('pay_ways.show', ['id' => $id, 'pay_way' => $pay_way]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if (count($request->old('pay_way')) > 0) {
            $pay_way = $request->old('pay_way');
        } else {
            $pay_way = OptionRepository::getOptionDetail($this->option_class, $id);
        }
        return view('pay_ways.edit', ['id' => $id, 'pay_way' => $pay_way]);
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
        $pay_way = $request->input('pay_way');
        OptionRepository::updateOption($this->option_class, $pay_way, $id);
        return redirect()->action('PayWayController@show', ['id' => $id])
                            ->with('status', [0 => '單位資料已更新!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        OptionRepository::deleteOption($this->option_class, $id);
        return redirect()->action('PayWayController@index')
                            ->with('status', [0 => '單位資料已刪除!']);
    }
}
