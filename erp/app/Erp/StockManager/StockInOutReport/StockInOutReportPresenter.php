<?php

namespace StockInOutReport;

class StockInOutReportPresenter
{
    public function getOrderLocalNameByOrderType($order_type, $class_name) {
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