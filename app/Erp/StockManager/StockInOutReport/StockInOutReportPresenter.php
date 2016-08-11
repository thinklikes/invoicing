<?php

namespace StockInOutReport;
/**
 * 庫存異動報表顯示邏輯
 */
class StockInOutReportPresenter
{
    /**
     * 回傳單據類型的中文名稱
     * @param  string $order_type 單據類型
     * @param  string $class_name 此資料model的class name
     * @return string             單據類型的中文名稱
     */
    public function getOrderLocalNameByOrderType($order_type, $class_name) 
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

    public function getNoTaxTotalAmount($tax_rate_code, $totalAmountWithTax)
    {
        
    }
}