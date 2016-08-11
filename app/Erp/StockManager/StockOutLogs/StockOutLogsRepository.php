<?php

namespace StockOutLogs;

use App;
use App\Repositories\BasicRepository;
use StockOutLogs\StockOutLogs as MainModel;
use DB;


class StockOutLogsRepository extends BasicRepository
{
    /**
     * 主要的model
     * @var StockInLogs\StockInLogs
     */
    protected $mainModel;

    public function __construct(MainModel $mainModel)
    {
        $this->mainModel = $mainModel;
    }

    /**
     * 新增一筆出庫記錄
     * @param string $order_type   單據類別
     * @param string $order_code   單據號碼
     * @param integer $warehouse_id 倉庫的id
     * @param integer $stock_id     料品的id
     * @param decimal $quantity     出庫數量
     */
    public function addStockOutLog($order_type, $order_code,
        $warehouse_id, $stock_id, $quantity)
    {
        $this->mainModel = new MainModel;

        $this->mainModel->order_type = $order_type;

        $this->mainModel->order_code = $order_code;

        $this->mainModel->warehouse_id = $warehouse_id;

        $this->mainModel->stock_id = $stock_id;

        $this->mainModel->quantity = $quantity;
        //開始存入
        return $this->mainModel->save();
    }

    /**
     * 刪除指定單據單號的出庫記錄
     * @param  string $order_type 單據類型
     * @param  string $order_code 單據號碼
     * @return boolean             刪除是否成功
     */
    public function deleteStockOutLogsByOrderCode($order_type, $order_code)
    {
        return $this->mainModel
            ->where('order_code', $order_code)
            ->where('order_type', $order_type)
            ->delete();
    }

    /**
     * 用取得料品的id取得出庫記錄
     * @param  integer $stock_id     料品的ID
     * @param  integer $warehouse_id 倉庫的ID
     * @param  string $start_date    查詢的起始日期
     * @param  string $end_date      查詢的結束日期
     * @return Collection            包含了型別為 StockOutLogs的資料
     */
    public function getStockOutLogsByStockId (
        $stock_id, $warehouse_id = null, $start_date = null, $end_date = null)
    {
        return $this->mainModel
            ->where('stock_id', $stock_id)
            ->where(function ($query) use ($warehouse_id, $start_date, $end_date)
            {
                if ($warehouse_id) {
                    $query->where('warehouse_id', '=', $warehouse_id);
                }

                if ($start_date) {
                    $query->where('created_at', '>=', $start_date);
                }

                if ($end_date) {
                    $query->where('created_at', '<=', $end_date);
                }
            })
            ->get();
    }
}