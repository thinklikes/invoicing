<?php

namespace Warehouse;

/**
 * 產生倉庫選項
 */
class WarehousePresenter {
    protected $warehouseRepository;

    public function __construct(WarehouseRepository $warehouseRepository) {
        $this->warehouseRepository = $warehouseRepository;
    }

    public function renderOptions($id = '') {
        $warehousesPair = $this->warehouseRepository->getAllWarehousesPair();
        $options = '';
        foreach ($warehousesPair as $warehouse_id => $name) {
            $options .= "<option value=\"$warehouse_id\"".
                ($warehouse_id == $id ? "selected" : "").
                ">$name</option>";
        }
        return $options;
    }
}