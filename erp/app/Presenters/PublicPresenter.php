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
    public function getFormatDate($date)
    {
        return (class_basename($date) == 'Carbon') ? $date->format('Y-m-d') : $date;
    }

    public function getNewDate()
    {
        return date('Y-m-d');
    }

    public function getTaxComment($tax_rate_code)
    {
        return ($tax_rate_code == "A")
            ? "稅外加"
            : ($tax_rate_code == "I")
                ? "稅內含" : "免稅額";
    }

    public function renderFormElement($item) {
        switch ($item->element) {
            case 'text':
                return "
                    <div class=\"form-group\">
                        <label>".$item->title."</label>
                        <input type=\"text\" class=\"form-control\"
                            name=\"".$item->name."\"
                            value=\"".$item->value."\">
                    </div>
                ";
                break;
            default:
                # code...
                break;
        }
    }
}

