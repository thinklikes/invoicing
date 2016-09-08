<?php

namespace App\Http\Controllers\Basic;

use Illuminate\Http\Request;
use Stock\StockRepository as Stock;
use App\Contracts\FormRequestInterface;
use App\Http\Requests\DestroyRequest;
use App\Http\Controllers\BasicController;

class StockController extends BasicController
{
    private $routeName = 'erp.basic.stock';
    private $stock;

    public function __construct(Stock $stock)
    {
        $this->middleware('page_auth');
        $this->stock = $stock;
        $this->setFullClassName();
    }
    /**
     * Display a listing of the resource in JSON.
     *
     * @return \Illuminate\Http\Response
     */
    public function json(Request $request)
    {
        $stocks = $this->stock->getStocksJson($request->input());
        return response()->json($stocks);
    }
    //條碼列印
    public function printBarcode($id = '')
    {
        if ($id) {
            $stocks = collect([
                $this->stock->getStockDetail($id)
            ]);
        } else {
            $stocks = $this->stock->getAllStocks();
        }
        return view($this->routeName.'.printBarcode', [
            'stocks' => $stocks
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view($this->routeName.'.index', [
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'stocks' => $this->stock
                ->getStockPaginated(
                    array_except($request->input(), 'page')
                ),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //找出之前輸入的資料
        $stock = $request->old('stock');
        //if(count($request->old()) > 0) dd($request->old());
        return view($this->routeName.'.create', ['stock' => $stock]);
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
        $stock = $request->input('stock');
        $new_id = $this->stock->storeStock($stock);

        //導回去此新增品項的詳細資料頁
        return redirect()->action("$this->className@show", ['id' => $new_id])
                            ->with('status', [0 => '料品資料已新增!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stock = $this->stock->getStockDetail($id);
        return view($this->routeName.'.show', ['id' => $id, 'stock' => $stock]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if (count($request->old('stock')) > 0) {
            $stock = $request->old('stock');
        } else {
            $stock = $this->stock->getStockDetail($id);
        }
        return view($this->routeName.'.edit', ['id' => $id, 'stock' => $stock]);
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
        $stock = $request->input('stock');
        $this->stock->updateStock($stock, $id);
        return redirect()->action("$this->className@show", ['id' => $id])
                            ->with('status', [0 => '料品資料已更新!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //檢查是否還有庫存量，若有則導回去詳細資料頁，並顯示不能刪除
        if ($this->stock->hasStockInventory($id)) {
            return redirect()->action("$this->className@show", ['id' => $id])
                                ->withErrors([0 => '這個料品在倉庫尚有庫存量，不能刪除!']);
        }
        $this->stock->deleteStock($id);
        return redirect()->action("$this->className@index")
                            ->with('status', [0 => '料品資料已刪除!']);
    }
}

