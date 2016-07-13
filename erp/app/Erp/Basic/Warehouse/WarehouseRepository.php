<?php

namespace Warehouse;

use DB;

class WarehouseRepository
{
    /**
     * find all warehouses
     * @return array all warehouses
     */
    public static function getAllWarehousesId()
    {
        $warehouses = Warehouse::select('id')
            ->get()
            ->toArray();
        //array_flatten() => 將多維的陣列轉成一維陣列
        $warehouses = array_flatten($warehouses);
        return $warehouses;
    }

    /**
     * find all pair warehouses = id:fullcomment
     * @return array all warehouses
     */
    public static function getAllWarehousesPair()
    {
        $warehouses = Warehouse::select(
                DB::raw('concat(code, " ",comment) as full_comment, id')
            )
            ->lists('full_comment', 'id');
        return $warehouses;
    }
    /**
     * find a page of warehouses
     * @return array all warehouses
     */
    public static function getWarehousesOnePage()
    {
        $warehouses = Warehouse::paginate(15);
        return $warehouses;
    }
    /**
     * find detail of one warehouse
     * @param  integer $id The id of warehouse
     * @return array       one warehouse
     */
    public static function getWarehouseDetail($id)
    {
        $warehouses = Warehouse::where('id', $id)
            ->firstOrFail();
        return $warehouses;
    }

    /**
     * store a warehouse
     * @param  integer $id The id of warehouse
     * @return void
     */
    public static function storeWarehouse($warehouse)
    {
        $new_warehouse = new Warehouse;
        $new_warehouse->class = $class;
        foreach($warehouse as $key => $value) {
            $new_warehouse->{$key} = $value;
        }
        $new_warehouse->save();
        return $new_warehouse->id;
    }

    /**
     * update a Warehouse
     * @param  integer $id The id of warehouse
     * @return void
     */
    public static function updateWarehouse($warehouse, $id)
    {
        $tmp_warehouse = Warehouse::findOrFail($id);
        foreach($warehouse as $key => $value) {
            $tmp_warehouse->{$key} = $value;
        }
        $tmp_warehouse->save();
    }

    /**
     * delete a Warehouse
     * @param  integer $id The id of warehouse
     * @return void
     */
    public static function deleteWarehouse($id)
    {
        $tmp_warehouse = Warehouse::findOrFail($id);
        $tmp_warehouse->delete();
    }
}