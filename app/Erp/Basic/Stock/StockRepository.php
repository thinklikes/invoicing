<?php

namespace Stock;

use DB;
use Warehouse\WarehouseRepository as Warehouse;

class StockRepository
{
    /**
     * find 15 Stocks to JSON
     * @return array all suppliers
     */
    public function getStocksJson($param)
    {
        $stocks = Stock::select('id', 'code', 'name', 'unit_id',
            'no_tax_price_of_purchased', 'no_tax_price_of_sold')
        ->with(['unit' => function($query) {
            $query->select('id', 'comment');
        }])
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
        return $stocks;
    }

    /**
     * 回傳是否在倉庫中尚有數量
     * @return boolean hasStockInventory
     */
    public function hasStockInventory($id) {
        $stock = Stock::find($id)->stocks_warehouses->sum('inventory');
        return (Integer) $stock <> 0;
    }

    /**
     * find a page of stocks pair
     * @return array all stocks
     */
    public function getStockPaginated($param)
    {
        return Stock::where(function ($query) use($param) {
            if (isset($param['name']) && $param['name'] != "") {
                $query->orWhere('name', 'like', "%".trim($param['name'])."%");
            }
            if (isset($param['code']) && $param['code'] != "") {
                $query->orWhere('code', 'like', "%".trim($param['code'])."%");
            }
        })->paginate(15);
    }
    /**
     * find detail of one stock
     * 這邊會抓出此料品及其位於各個倉庫所有的庫存量，並且會回傳倉庫名稱
     *
     * Stock          => 料品主檔的model
     * StockWarehouse => 料品與倉庫的中介表，並存入了庫存數量
     * Option         => 記錄了倉庫資訊
     *
     * 關聯如下
     * Stock.php          : Stock->hasMany(StockWarehouse);
     * StockWarehouse.php : StockWarehouse->belongsTo(Option)
     * @param  integer $id The id of stock
     * @return array       one stock
     */
    public function getStockDetail($id)
    {
        $stocks = Stock::find($id);
        return $stocks;
    }

    /**
     * 取得所有的料品編號與名稱
     * @return collection     內容是Stock\Stock的集合
     */
    public function getAllStocks()
    {
        return Stock::orderBy('id', 'desc')->get();
    }

    /**
     * store a stock
     * @param  integer $id The id of stock
     * @return void
     */
    public function storeStock($stock)
    {
        $new_stock = new Stock;
        foreach($stock as $key => $value) {
            $new_stock->{$key} = $value;
        }
        $new_stock->save();

        //寫入stocks_warehouses, 多對多關聯
        //Stock->warehouse() 記錄了多對多關聯
        $new_stock->warehouse()->attach(Warehouse::getAllWarehousesId());

        return $new_stock->id;
    }

    /**
     * update a stock
     * @param  integer $id The id of stock
     * @return void
     */
    public function updateStock($stock, $id)
    {
        $tmp_stock = Stock::find($id);
        foreach($stock as $key => $value) {
            $tmp_stock->{$key} = $value;
        }
        $tmp_stock->save();
    }

    /**
     * delete a stock
     * @param  integer $id The id of stock
     * @return void
     */
    public function deleteStock($id)
    {
        $tmp_stock = Stock::find($id);
        $tmp_stock->delete();
    }
}