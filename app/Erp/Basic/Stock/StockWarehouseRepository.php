<?php

namespace Stock;

use DB;

class StockWarehouseRepository
{
    protected $stockWarehouse;

    /**
     * StockWarehouseRepository constructor.
     *
     * @param StockWarehouse $puchase_order_master
     */
    public function __construct()
    {
        $this->stockWarehouse = new StockWarehouse;
    }

    /**
     * 取得所有庫存數量大於零的資料
     * @param  string $stock_id     料品的id
     * @param  string $warehouse_id 倉庫的id
     * @return collection           內容是StockWarehouse的資料
     */
    public function getAllData($stock_id = '', $warehouse_id = '')
    {

        return $this->stockWarehouse->where('inventory', '!=', '0')
            ->where(function ($query) use ($stock_id, $warehouse_id) {
                if ($stock_id != '') {
                    $query->where('stock_id', $stock_id);
                }
                if ($warehouse_id != '') {
                    $query->where('warehouse_id', $warehouse_id);
                }
            })
            ->get();

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
    public function incrementInventory($inventory, $stock_id, $warehouse_id)
    {
        return $this->stockWarehouse->where('stock_id', $stock_id)
            ->where('warehouse_id', $warehouse_id)
            ->increment('inventory', $inventory);
    }
}