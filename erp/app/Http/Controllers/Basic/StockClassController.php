<?php

namespace App\Http\Controllers\Basic;

use Illuminate\Http\Request;
use Option\OptionRepository;
use App\Contracts\FormRequestInterface;
use App\Http\Controllers\BasicController;

class StockClassController extends BasicController
{
    private $namespace;
    protected $className;
    private $option_class = 'stock_classes';
    private $routeName = 'erp.basic.stock_class';

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
        $stock_classes = OptionRepository::getOptionsOnePage($this->option_class);
        return view($this->routeName.'.index', ['stock_classes' => $stock_classes]);
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
        return view($this->routeName.'.create', ['stock_class' => $stock_class]);
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
        $stock_class = $request->input('stock_class');
        $new_id = OptionRepository::storeOption($this->option_class, $stock_class);
        return redirect()->action(
                "$this->className@show", ['id' => $new_id])
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
        return view($this->routeName.'.show', ['id' => $id, 'stock_class' => $stock_class]);
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
        return view($this->routeName.'.edit', ['id' => $id, 'stock_class' => $stock_class]);
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
        $stock_class = $request->input('stock_class');
        OptionRepository::updateOption($this->option_class, $stock_class, $id);
        return redirect()->action(
                "$this->className@show", ['id' => $id])
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
        return redirect()->action(
                "$this->className@index")
            ->with('status', [0 => '料品類別已刪除!']);
    }
}
