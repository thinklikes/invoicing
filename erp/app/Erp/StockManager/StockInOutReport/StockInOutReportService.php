<?php
namespace StockInOutReport;

use BillOfPurchase\BillOfPurchaseMaster as BillOfPurchaseDetail;
use ReturnOfPurchase\ReturnOfPurchaseMaster as ReturnOfPurchase;
use BillOfSale\BillOfSaleMaster as BillOfSale;
use ReturnOfSale\ReturnOfSaleMaster as ReturnOfSale;
use StockInOut\StockInOutMaster as StockInOut;
use StockTransfer\StockTransferMaster as StockTransfer;
use Illuminate\Support\MessageBag;
use App;
use DB;

class StockInOutReportService
{
    protected $billOfPurchase;
    protected $returnOfPurchase;
    protected $billOfSale;
    protected $returnOfSale;
    protected $stockInOut;
    protected $stockTransfer;

    public function __construct(
        BillOfPurchaseDetail $billOfPurchase,
        ReturnOfPurchase $returnOfPurchase,
        BillOfSale $billOfSale,
        ReturnOfSale $returnOfSale,
        StockInOut $stockInOut,
        StockTransfer $stockTransfer)
    {
        $this->billOfPurchase   = $billOfPurchase;
        $this->returnOfPurchase = $returnOfPurchase;
        $this->billOfSale       = $billOfSale;
        $this->returnOfSale     = $returnOfSale;
        $this->stockInOut       = $stockInOut;
        $this->stockTransfer    = $stockTransfer;
    }

    public function getAllStockInOutRecordsInDateRange(
        $stock_id, $warehouse_id = '', $start_date = '', $end_date = '')
    {
        $data = array();
        $data = array_merge(
            $data,

            $this->getBillOfPurchaseRecordsInDateRange(
                $stock_id, $warehouse_id, $start_date, $end_date),

            $this->getReturnOfPurchaseRecordsInDateRange(
                $stock_id, $warehouse_id, $start_date, $end_date),

            $this->getBillOfSaleRecordsInDateRange(
                $stock_id, $warehouse_id, $start_date, $end_date),

            $this->getReturnOfSaleRecordsInDateRange(
                $stock_id, $warehouse_id, $start_date, $end_date),

            $this->getStockInOutRecordsInDateRange(
                $stock_id, $warehouse_id, $start_date, $end_date)
        );

        return collect($data);
    }

    private function getBillOfPurchaseRecordsInDateRange(
        $stock_id, $warehouse_id = '', $start_date = '', $end_date = '')
    {
        return $this->billOfPurchase
            //預載入對應表身的關聯
            ->with(['orderDetail' => function ($query) use($stock_id)
            {
                $query->select('stock_id', 'quantity', 'master_code');
                $query->where('stock_id', '=', $stock_id);
            }])
            ->select('code', 'warehouse_id', 'created_at')
            //設定單據的類型
            ->addSelect(DB::raw('"進貨" as orderType'))
            //過濾表頭的條件
            ->where(function ($query) use ($warehouse_id, $start_date, $end_date)
            {
                if ($warehouse_id != '') {
                    $query->where('warehouse_id', '=', $warehouse_id);
                }

                if ($start_date != '') {
                    $query->where('created_at', '>=', $start_date);
                }

                if ($end_date != '') {
                    $query->where('created_at', '<=', $end_date);
                }
            })
            //關聯的表身中若有以下條件才把表頭資料抓出來
            ->whereHas('orderDetail', function ($query) use($stock_id)
            {
                $query->where('stock_id', '=', $stock_id);
            })
            ->get()->all();
    }

    public function getReturnOfPurchaseRecordsInDateRange(
        $stock_id, $warehouse_id = '', $start_date = '', $end_date = '')
    {
        return $this->returnOfPurchase
            //預載入對應表身的關聯
            ->with(['orderDetail' => function ($query) use($stock_id)
            {
                $query->select('stock_id', 'master_code');
                $query->addSelect(DB::raw('quantity * -1 as quantity'));
                $query->where('stock_id', '=', $stock_id);
            }])
            ->select('code', 'warehouse_id', 'created_at')
            //設定單據的類型
            ->addSelect(DB::raw('"進退" as orderType'))
            //過濾表頭的條件
            ->where(function ($query) use ($warehouse_id, $start_date, $end_date)
            {
                if ($warehouse_id != '') {
                    $query->where('warehouse_id', '=', $warehouse_id);
                }

                if ($start_date != '') {
                    $query->where('created_at', '>=', $start_date);
                }

                if ($end_date != '') {
                    $query->where('created_at', '<=', $end_date);
                }
            })
            //關聯的表身中若有以下條件才把表頭資料抓出來
            ->whereHas('orderDetail', function ($query) use($stock_id)
            {
                $query->where('stock_id', '=', $stock_id);
            })
            ->get()->all();
    }
    public function getBillOfSaleRecordsInDateRange(
        $stock_id, $warehouse_id = '', $start_date = '', $end_date = '')
    {
        return $this->billOfSale
            //預載入對應表身的關聯
            //因為是銷貨，數量乘以-1
            ->with(['orderDetail' => function ($query) use($stock_id)
            {
                $query->select('stock_id', 'master_code');
                $query->addSelect(DB::raw('quantity * -1 as quantity'));
                $query->where('stock_id', '=', $stock_id);
            }])
            ->select('code', 'warehouse_id', 'created_at')
            //設定單據的類型
            ->addSelect(DB::raw('"銷貨" as orderType'))
            //過濾表頭的條件
            ->where(function ($query) use ($warehouse_id, $start_date, $end_date)
            {
                if ($warehouse_id != '') {
                    $query->where('warehouse_id', '=', $warehouse_id);
                }

                if ($start_date != '') {
                    $query->where('created_at', '>=', $start_date);
                }

                if ($end_date != '') {
                    $query->where('created_at', '<=', $end_date);
                }
            })
            //關聯的表身中若有以下條件才把表頭資料抓出來
            ->whereHas('orderDetail', function ($query) use($stock_id)
            {
                $query->where('stock_id', '=', $stock_id);
            })
            ->get()->all();
    }
    public function getReturnOfSaleRecordsInDateRange(
        $stock_id, $warehouse_id = '', $start_date = '', $end_date = '')
    {
        return $this->returnOfSale
            //預載入對應表身的關聯
            ->with(['orderDetail' => function ($query) use($stock_id)
            {
                $query->select('stock_id', 'quantity', 'master_code');
                $query->where('stock_id', '=', $stock_id);
            }])
            ->select('code', 'warehouse_id', 'created_at')
            //設定單據的類型
            ->addSelect(DB::raw('"銷退" as orderType'))
            //過濾表頭的條件
            ->where(function ($query) use ($warehouse_id, $start_date, $end_date)
            {
                if ($warehouse_id != '') {
                    $query->where('warehouse_id', '=', $warehouse_id);
                }

                if ($start_date != '') {
                    $query->where('created_at', '>=', $start_date);
                }

                if ($end_date != '') {
                    $query->where('created_at', '<=', $end_date);
                }
            })
            //關聯的表身中若有以下條件才把表頭資料抓出來
            ->whereHas('orderDetail', function ($query) use($stock_id)
            {
                $query->where('stock_id', '=', $stock_id);
            })
            ->get()->all();
    }

    public function getStockInOutRecordsInDateRange(
        $stock_id, $warehouse_id = '', $start_date = '', $end_date = '')
    {
        return $this->stockInOut
            //預載入對應表身的關聯
            ->with(['orderDetail' => function ($query) use($stock_id)
            {
                $query->select('stock_id', 'quantity', 'master_code');
                $query->where('stock_id', '=', $stock_id);
            }])
            ->select('code', 'warehouse_id', 'created_at')
            //設定單據的類型
            ->addSelect(DB::raw('"調整" as orderType'))
            //過濾表頭的條件
            ->where(function ($query) use ($warehouse_id, $start_date, $end_date)
            {
                if ($warehouse_id != '') {
                    $query->where('warehouse_id', '=', $warehouse_id);
                }

                if ($start_date != '') {
                    $query->where('created_at', '>=', $start_date);
                }

                if ($end_date != '') {
                    $query->where('created_at', '<=', $end_date);
                }
            })
            //關聯的表身中若有以下條件才把表頭資料抓出來
            ->whereHas('orderDetail', function ($query) use($stock_id)
            {
                $query->where('stock_id', '=', $stock_id);
            })
            ->get()->all();
    }
}