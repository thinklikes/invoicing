<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Option\OptionRepository;
use App\Contracts\FormRequestInterface;
use App\Http\Requests\DestroyRequest;
use App\Http\Controllers\BasicController;

class UnitController extends BasicController
{
    private $option_class = 'units';
    private $routeName = 'erp.basic.unit';

    public function __construct()
    {
        $this->middleware('page_auth');
        $this->setFullClassName();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = OptionRepository::getOptionsOnePage($this->option_class);
        return view($this->routeName.'.index', ['units' => $units]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //找出之前輸入的資料
        $unit = $request->old('unit');
        //if(count($request->old()) > 0) dd($request->old());
        return view($this->routeName.'.create', ['unit' => $unit]);
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
        $unit = $request->input('unit');
        $new_id = OptionRepository::storeOption($this->option_class, $unit);
        return redirect()->action("$this->className@show", ['id' => $new_id])
                            ->with('status', [0 => '料品單位已新增!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unit = OptionRepository::getOptionDetail($this->option_class, $id);
        return view($this->routeName.'.show', ['id' => $id, 'unit' => $unit]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if (count($request->old('unit')) > 0) {
            $unit = $request->old('unit');
        } else {
            $unit = OptionRepository::getOptionDetail($this->option_class, $id);
        }
        return view($this->routeName.'.edit', ['id' => $id, 'unit' => $unit]);
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
        $unit = $request->input('unit');
        OptionRepository::updateOption($this->option_class, $unit, $id);
        return redirect()->action("$this->className@show", ['id' => $id])
                            ->with('status', [0 => '料品單位已更新!']);
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
        return redirect()->action("$this->className@index")
                            ->with('status', [0 => '料品單位已刪除!']);
    }
}
