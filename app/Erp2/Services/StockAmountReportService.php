<?php
namespace Erp\Services;

use Erp\Services\ReportServiceInterface;
use Illuminate\Support\MessageBag;

class StockAmountReportService implements ReportServiceInterface
{
    /**
     * 此程式的中文名稱
     * @var string
     */
    private $chname = '庫存總表';

    /**
     * 此程式的表單陣列名稱
     * @var string
     */
    private $headName = 'stockAmountReport';
    /**
     * 此程式的view的path
     * @var string
     */
    private $viewPath = 'erp.stockManager.stockAmountReport';
    /**
     * 取得此報告的資料
     * @param  array  $parameter  用於過濾的參數
     * @param  string $start_date 報告查詢啟始日
     * @param  string $end_date   報告查詢結束日
     * @return collection             報告內容
     */
    public function getReportData($parameter = [], $start_date = '', $end_date = '')
    {

    }
    public function getProperty($key)
    {
        if ($key == 'required') {
            return self::$required;
        }
        return $this->{$key};
    }
}