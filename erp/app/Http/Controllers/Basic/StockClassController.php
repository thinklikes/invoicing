<?php

namespace App\Http\Basic\Controllers;

use Illuminate\Http\Request;

use App\Repositories\OptionRepository;

use App\Http\Requests\ErpRequest;

class StockClassController extends Controller
{
    private $option_class = 'stock_classes';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stock_classes = OptionRepository::getOptionsOnePage($this->option_class);
        return view('stock_classes.index', ['stock_classes' => $stock_classes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //找出之前輸入的資料
        $stock_class = $request->old('stock_class');
        //if(count($request->old()) > 0) dd($request->old());
        return view('stock_classes.create', ['stock_class' => $stock_class]);
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
        $stock_class = $request->input('stock_class');
        $new_id = OptionRepository::storeOption($this->option_class, $stock_class);
        return redirect()->action('StockClassController@show', ['id' => $new_id])
                            ->with('status', [0 => '料品類別已新增!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stock_class = OptionRepository::getOptionDetail($this->option_class, $id);
        return view('stock_classes.show', ['id' => $id, 'stock_class' => $stock_class]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if (count($request->old('stock_class')) > 0) {
            $stock_class = $request->old('stock_class');
        } else {
            $stock_class = OptionRepository::getOptionDetail($this->option_class, $id);
        }
        return view('stock_classes.edit', ['id' => $id, 'stock_class' => $stock_class]);
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
        $stock_class = $request->input('stock_class');
        OptionRepository::updateOption($this->option_class, $stock_class, $id);
        return redirect()->action('StockClassController@show', ['id' => $id])
                            ->with('status', [0 => '料品類別已更新!']);
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
        return redirect()->action('StockClassController@index')
                            ->with('status', [0 => '料品類別已刪除!']);
    }
}
