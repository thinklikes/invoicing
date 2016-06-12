<?php

namespace App\Repositories;

use App\StockWarehouse;

use DB;

use Schema;

class StockWarehouseRepository
{
    protected $stockWarehouse;

    /**
     * StockWarehouseRepository constructor.
     *
     * @param StockWarehouse $puchase_order_master
     */
    public function __construct(StockWarehouse $stockWarehouse)
    {
        $this->stockWarehouse = $stockWarehouse;
    }

    /**
     * get all records of stock warehouse by stock id
     * @return array all purchases
     */
    public function getAllRecordsOfStockWarehouseByStockId($stock_id)
    {
        return $this->stockWarehouse->where('stock_id', $stock_id)->get());
    }

    /**
     * get all records of stock warehouse by warehouse id
     * @return array all purchases
     */
    public function getAllRecordsOfStockWarehouseByWarehouseId($warehouse_id)
    {
        return $this->stockWarehouse->where('warehouse_id', $stock_id)->get());
    }

    /**
     * store a record of stock warehouse
     * @param  integer $id The id of purchase
     * @return void
     */
    // public function storeStockWarehouse($stockWarehouse)
    // {
    //     //找出資料表所有的欄位
    //     $columns = $this->getTableColumnList($this->stockWarehouse);

    //     $this->stockWarehouse = new StockWarehouse;

    //     //判斷request傳來的欄位是否存在，有才存入此欄位數值
    //     foreach($columns as $key) {
    //         if (isset($stockWarehouse[$key])) {
    //             $this->stockWarehouse->{$key} = $stockWarehouse[$key];
    //         }
    //     }

    //     //開始存入
    //     $this->stockWarehouse->save();

    //     return $this->stockWarehouse->code;
    // }

    /**
     * update a record of stock warehouse
     * @param  array $stockWarehouse   stock warehouse record
     * @param  integer $stock_id       stock id
     * @param  integer $warehouse_id   warehouse id
     * @return boolean                 if save success, return true
     */
    public function updateInventory($inventory, $stock_id, $warehouse_id)
    {
        //找出表頭資料表所有的欄位
        $columns = $this->getTableColumnList($this->stockWarehouse);

        $this->stockWarehouse = $this->stockWarehouse
            ->where('stock_id', $stock_id)
            ->where('warehouse_id', $warehouse_id)
            ->first();

        $this->stockWarehouse->inventory = $this->stockWarehouse->inventory + $inventory;

        return $this->stockWarehouse->save();
    }
}