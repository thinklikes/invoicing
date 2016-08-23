<?php

namespace Erp\Services;

interface ReportServiceInterface
{
    /**
     * 取得此報告的資料
     * @param  array  $parameter  用於過濾的參數
     * @return collection             報告內容
     */
    public function getReportData($parameter = []);

    /**
     * 取得屬性值
     * @param  string  $key  屬性的鍵值
     * @return string|array  屬性值
     */
    public function getProperty($key);
}