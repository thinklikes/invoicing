<?php

/**
 * the system settings
 */
return [
    // 網站標題
    'website_title'           => env('WEBSITE_TITLE', '進銷存管理系統'),
    // 系統建立日期
    'system_build_date'       => env('SYSTEM_BUILD_DATE', '0000-00-00'),
    // 公司名稱
    'company_name'            => env('COMPANY_NAME', '進銷存管理系統'),
    // 公司地址
    'company_address'         => env('COMPANY_ADDRESS', ''),
    // 公司電話
    'company_phone_number'    => env('COMPANY_PHONE_NUMBER', ''),

    // 進貨稅率
    'purchase_tax_rate'       => env('PURCHASE_TAX_RATE', '0.05'),
    // 銷貨稅率
    'sale_tax_rate'           => env('SALE_TAX_RATE', '0.05'),
    // 數量小數點位數
    'quantity_round_off'      => env('QUANTITY_ROUND_OFF', '2'),
    // 稅前單價小數點位數
    'no_tax_price_round_off'  => env('NO_TAX_PRICE_ROUND_OFF', '2'),
    // 小計小數點位數
    'no_tax_amount_round_off' => env('NO_TAX_AMOUNT_ROUND_OFF', '2'),
    // 營業稅小數點位數
    'tax_round_off'           => env('TAX_ROUND_OFF', '0'),
    // 總計小數點位數
    'total_amount_round_off'  => env('TOTAL_AMOUNT_ROUND_OFF', '0'),

];