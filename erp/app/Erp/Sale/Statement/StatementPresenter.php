<?php
namespace Statement;

/**
 * 對帳單的顯示邏輯
 */
class StatementPresenter
{
    /**
     * 回傳單據類型的中文名稱
     * @param  string $class_name 此資料model的class name
     * @return string             單據類型的中文名稱
     */
    public function getOrderLocalNameByOrderType($class_name)
    {
        switch ($class_name) {
            case 'BillOfSaleMaster':
                return '銷貨';
                break;
            case 'ReturnOfSaleMaster':
                return '銷退';
                break;
            default:
                return '';
                break;
        }
    }
}