<?php

namespace Erp\Services;

interface ReportServiceInterface
{
    /**
     * 取得此報告的資料
     * @param  array  $parameter  用於過濾的參數
     * @param  string $start_date 報告查詢啟始日
     * @param  string $end_date   報告查詢結束日
     * @return collection             報告內容
     */
    public function getReportData($parameter = [], $start_date = '', $end_date = '');
}