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

    /**
     * 依照傳入的稅別回傳中文說明
     * @param  string $tax_rate_code 稅別代號
     * @return string                稅別中文說明
     */
    public function getTaxComment($tax_rate_code)
    {

        return ($tax_rate_code == "A")
            ? "稅外加"
            : (
                ($tax_rate_code == "I")
                    ? "稅內含" : "免稅額"
            );
    }

    /**
     * 依照傳入的類型回傳HTML元素
     * @param  string $type  HTML元素的類型
     * @param  string $name  HTML元素的名稱
     * @param  string $value HTML元素的數值
     * @return string        HTML元素的文本
     */
    public function renderHtmlElement($type, $name = '', $value = '', $source = array()) {
        switch ($type) {
            case 'text':
                return "<input type=\"text\" class=\"form-control\"
                    name=\"$name\" value=\"$value\">";
                break;
            case 'password':
                //如果是密碼類型，則清空它
                $value = '';
                return "<input type=\"password\" class=\"form-control\"
                    name=\"$name\" value=\"$value\">";
                break;
            case 'textarea':
                return "<textarea class=\"form-control\"
                    name=\"$name\">$value</textarea>";
                break;
            case 'date':
                return "<input type=\"text\" class=\"form-control datepicker\"
                    name=\"$name\" value=\"$value\">";
                break;
            case 'select':
                $html = "<select name=\"$name\" class=\"form-control\">";
                $html .= "<option></option>";
                foreach ($source as $key => $comment) {
                    # code...
                    $html .= "<option value=\"$key\">$comment</option>";
                }
                $html .= "</select>";
                return $html;
                break;
            default:
                return "<input type=\"text\" class=\"form-control\"
                    name=\"$name\" value=\"$value\">";
                break;
        }
    }

    /**
     * 回傳單據類型的中文名稱
     * @param  string $class_name 此資料model的class name
     * @return string             單據類型的中文名稱
     */
    public function getOrderLocalNameByOrderType($class_name, $order_type = '')
    {
        switch ($order_type) {
            case 'billOfPurchase':
                return '進貨';
                break;
            case 'returnOfPurchase':
                return '進退';
                break;
            case 'billOfSale':
                return '銷貨';
                break;
            case 'returnOfSale':
                return '銷退';
                break;
            case 'stockAdjust':
                return '調整';
                break;
            case 'stockTransfer':
                if ($class_name == 'StockInLogs') {
                    return '調入';
                }
                return '調出';
                break;
            default:
                return '';
                break;
        }
    }
}

