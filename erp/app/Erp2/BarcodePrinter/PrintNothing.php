<?php

namespace Erp\BarcodePrinter;

use Erp\BarcodePrinter\BarcodePrinterInterface;

class PrintNothing implements BarcodePrinterInterface
{
    /**
     * 使控制器獲得可以產生barcode的方法
     * @param  Collection $item 用於列印條碼的資料集合
     * @return Response          回傳Response物件
     */
    public function printBarcode($item)
    {
        abort(404);
    }
}