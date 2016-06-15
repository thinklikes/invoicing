<?php

namespace App\Presenters;

use Carbon\Carbon;

class PublicPresenter
{

    /**
     * 轉換成固定格式的日期
     * Carbon => 日期套件
     * @param Carbon $date
     * @return date
     */
    public function getFormatDate(Carbon $date)
    {
        return $date->format('Y-m-d');
    }

    public function getNewDate()
    {
        return date('Y-m-d');
    }

    public function getTaxComment($tax_rate_code)
    {
        return ($tax_rate_code == "A") ? "稅外加" : "稅內含";
    }
}

