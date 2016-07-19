<?php
namespace StockInOutReport;

use BillOfPurchase\BillOfPurchaseDetail as BillOfPurchaseDetail;
// use ReturnOfPurchase\ReturnOfPurchaseDetail as ReturnOfPurchase;
// use BillOfSale\BillOfSaleMaster as BillOfSale;
// use ReturnOfSale\ReturnOfSaleMaster as ReturnOfSale;
// use StockInOut\StockInOutMaster as StockInOut;
// use StockTransfer\StockTransferMaster as StockTransfer;
use Illuminate\Support\MessageBag;
use App;

class StockInOutReportService
{
    protected $billOfPurchase;
    protected $returnOfPurchase;
    protected $billOfSale;
    protected $returnOfSale;
    protected $stockInOut;
    protected $stockTransfer;

    public function __construct(
        BillOfPurchaseDetail $billOfPurchase)
        //ReturnOfPurchase $returnOfPurchase,
        //BillOfSale $billOfSale,
        //ReturnOfSale $returnOfSale,
        //StockInOut $stockInOut,
        //StockTransfer $stockTransfer)
    {
        $this->billOfPurchase   = $billOfPurchase;
        // $this->returnOfPurchase = $returnOfPurchase;
        // $this->billOfSale       = $billOfSale;
        // $this->returnOfSale     = $returnOfSale;
        // $this->stockInOut       = $stockInOut;
        // $this->stockTransfer    = $stockTransfer;
    }

    public function getStockInOutRecordsInDateRange(
        $stock_id, $warehouse_id = '', $start_date = '', $end_date = '')
    {
        $data1 = $this->getBillOfPurchaseRecordsInDateRange(
            $stock_id, $warehouse_id, $start_date, $end_date);
        // $data2 = $this->getReturnOfPurchaseRecordsInDateRange(
        //     $stock_id, $warehouse_id, $start_date, $end_date);
        // $data3 = $this->getBillOfSaleRecordsInDateRange(
        //     $stock_id, $warehouse_id, $start_date, $end_date);
        // $data4 = $this->getReturnOfSaleRecordsInDateRange(
        //     $stock_id, $warehouse_id, $start_date, $end_date);
        // $data5 = $this->getStockInOutRecordsInDateRange(
        //     $stock_id, $warehouse_id, $start_date, $end_date);
        // $data6 = $this->getBillOfPurchaseRecordsInDateRange(
        //     $stock_id, $warehouse_id, $start_date, $end_date);
        dd($data1);
        $collection = collect([$data1, $data2, $data3, $data4]);
        return $collection;
    }

    private function getBillOfPurchaseRecordsInDateRange(
        $stock_id, $warehouse_id = '', $start_date = '', $end_date = '')
    {
        return $this->billOfPurchase
            ->with([
                'orderMaster' => function ($query) use(
                    $warehouse_id, $start_date, $end_date)
                {
                    $query->select('code', 'warehouse_id');

                    if ($warehouse_id != '') {
                        $query->where('warehouse_id', '=', $warehouse_id);
                    }

                    if ($start_date != '') {
                        $query->where('created_at', '>', $start_date);
                    }

                    if ($end_date != '') {
                        $query->where('created_at', '<', $end_date);
                    }
                }
            ])
            ->select('stock_id', 'quantity', 'master_code')
            ->where('stock_id', $stock_id)
            ->get();
    }

    public function getReturnOfPurchaseRecordsInDateRange(
        $stock_id, $warehouse_id = '', $start_date = '', $end_date = '')
    {
        return $this->returnOfPurchase
            ->select('code', 'warehouse_id')
            ->with([
                'returnOfPurchaseDetail' => function ($query) use($stock_id)
                {
                    $query->select('stock_id', 'quantity', 'master_code')
                        ->where('stock_id', $stock_id);
                }
            ])
            ->where(function ($query) use ($warehouse_id, $start_date, $end_date)
                {
                    if ($warehouse_id != '') {
                        $query->where('warehouse_id', '=', $warehouse_id);
                    }
                    if ($start_date != '') {
                        $query->where('created_at', '>', $start_date);
                    }
                    if ($end_date != '') {
                        $query->where('created_at', '<', $end_date);
                    }
                }
            )
            ->get();
    }
    public function getBillOfSaleRecordsInDateRange(
        $stock_id, $warehouse_id = '', $start_date = '', $end_date = '')
    {
        return $this->billOfSale
            ->select('code', 'warehouse_id')
            ->with([
                'billOfSaleDetail' => function ($query) use($stock_id)
                {
                    $query->select('stock_id', 'quantity', 'master_code')
                        ->where('stock_id', $stock_id);
                }
            ])
            ->where(function ($query) use ($warehouse_id, $start_date, $end_date)
                {
                    if ($warehouse_id != '') {
                        $query->where('warehouse_id', '=', $warehouse_id);
                    }
                    if ($start_date != '') {
                        $query->where('created_at', '>', $start_date);
                    }
                    if ($end_date != '') {
                        $query->where('created_at', '<', $end_date);
                    }
                }
            )
            ->get();
    }
    public function getReturnOfSaleRecordsInDateRange(
        $stock_id, $warehouse_id = '', $start_date = '', $end_date = '')
    {
        return $this->returnOfSale
            ->select('code', 'warehouse_id')
            ->with([
                'returnOfSaleDetail' => function ($query) use($stock_id)
                {
                    $query->select('stock_id', 'quantity', 'master_code')
                        ->where('stock_id', $stock_id);
                }
            ])
            ->where(function ($query) use ($warehouse_id, $start_date, $end_date)
                {
                    if ($warehouse_id != '') {
                        $query->where('warehouse_id', '=', $warehouse_id);
                    }
                    if ($start_date != '') {
                        $query->where('created_at', '>', $start_date);
                    }
                    if ($end_date != '') {
                        $query->where('created_at', '<', $end_date);
                    }
                }
            )
            ->get();
    }
}