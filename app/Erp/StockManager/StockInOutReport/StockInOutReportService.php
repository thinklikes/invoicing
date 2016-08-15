<?php
namespace StockInOutReport;

use StockInLogs\StockInLogsRepository as StockInLogs;
use StockOutLogs\StockOutLogsRepository as StockOutLogs;
use Illuminate\Support\MessageBag;
use App;

class StockInOutReportService
{
    protected $stockInLogs;
    protected $stockOutLogs;

    public function __construct(
        StockInLogs $stockInLogs,
        StockOutLogs $stockOutLogs)
    {
        $this->stockInLogs  = $stockInLogs;
        $this->stockOutLogs = $stockOutLogs;
    }

    /**
     * 用取得料品的id取得出庫記錄，並且以created_at來排序
     * @param  integer $stock_id     料品的ID
     * @param  integer $warehouse_id 倉庫的ID
     * @param  string $start_date    查詢的起始日期
     * @param  string $end_date      查詢的結束日期
     * @return Collection            包含了型別為 StockInLogs或StockOutLogs的資料
     */
    public function getStockInOutLogsByStockId(
        $stock_id = '', $warehouse_id = '', $start_date = '', $end_date = '')
    {
        $data = collect([]);
        //抓出這個料品ID的入庫資料
        $data = $data->merge($this->stockInLogs->getStockInLogsByStockId(
            $stock_id, $warehouse_id, $start_date, $end_date));
        //抓出這個料品ID的出庫資料
        $data = $data->merge($this->stockOutLogs->getStockOutLogsByStockId(
            $stock_id, $warehouse_id, $start_date, $end_date));

        //回傳的資料用created_at這個欄位來排序
        return $data->sortBy('created_at');
    }

}