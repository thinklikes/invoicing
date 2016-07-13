<?php

namespace App\Http\Controllers\Basic;

use Illuminate\Http\Request;
use Option\OptionRepository;
use App\Contracts\FormRequestInterface;
use App\Http\Controllers\BasicController;

class PayWayController extends BasicController
{
    private $option_class = 'pay_ways';
    private $routeName = 'erp.basic.pay_way';
    protected $className    = 'PayWayController';


    public function __construct()
    {
        $this->setFullClassName();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pay_ways = OptionRepository::getOptionsOnePage($this->option_class);
        return view($this->routeName.'.index', ['pay_ways' => $pay_ways]);
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
        return view($this->routeName.'.create', ['pay_way' => $pay_way]);
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
        $pay_way = $request->input('pay_way');
        $new_id = OptionRepository::storeOption($this->option_class, $pay_way);
        return redirect()->action(
                "$this->className@show", ['id' => $new_id])
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
        return view($this->routeName.'.show', ['id' => $id, 'pay_way' => $pay_way]);
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
        return view($this->routeName.'.edit', ['id' => $id, 'pay_way' => $pay_way]);
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
        $pay_way = $request->input('pay_way');
        OptionRepository::updateOption($this->option_class, $pay_way, $id);
        return redirect()->action(
                "$this->className@show", ['id' => $id])
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
        return redirect()->action(
                "$this->className@index")
            ->with('status', [0 => '單位資料已刪除!']);
    }
}
