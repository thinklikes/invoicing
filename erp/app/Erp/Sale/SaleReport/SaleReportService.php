<?php
namespace SaleReport;

use BillOfSale\BillOfSaleRepository as BillOfSale;
use ReturnOfSale\ReturnOfSaleRepository as ReturnOfSale;
use Illuminate\Support\MessageBag;
use App;
use DB;

class SaleReportService
{
    protected $billOfSale;
    protected $returnOfSale;

    public function __construct(
        BillOfSale $billOfSale,
        ReturnOfSale $returnOfSale)
    {
        $this->billOfSale  = $billOfSale;
        $this->returnOfSale = $returnOfSale;
    }

    /**
     * 用客戶的id去找出客戶資料
     * @param  integer $company_id 客戶的id
     * @return Company\Company             客戶的model
     */
    public function findCompanyByCompanyId($company_id) {
        return $this->company->getCompanyById($company_id);
    }

    /**
     * 用客戶的id取得銷貨記錄，並且以created_at來排序
     * @param  integer $stock_id     料品的ID
     * @param  string $start_date    查詢的起始日期
     * @param  string $end_date      查詢的結束日期
     * @return Collection            包含了型別為 StockInLogs或StockOutLogs的資料
     */
    public function getSaleReportByConditions(
        $company_id = null, $stock_id = null, $start_date = null, $end_date = null)
    {
        $data = collect([]);

        $sale_tax_rate = config('system_configs.sale_tax_rate');
        $no_tax_amount_round_off = config('system_configs.no_tax_amount_round_off');
        $tax_round_off = config('system_configs.tax_round_off');

        $data = $data->merge($this->billOfSale
                ->getFullOrderDetailByConditions($company_id, $stock_id, $start_date, $end_date)
                ->map(function ($item, $key) use (
                    $sale_tax_rate, $no_tax_amount_round_off, $tax_round_off)
                {
                    //從這裡開始遍歷每張銷貨單
                    //算出單張銷貨單的總金額, 稅額等
                    $item->tax = round($item->total_amount * $sale_tax_rate, $tax_round_off);

                    $item->total_no_tax_amount = round($item->total_amount - $item->tax,
                         $no_tax_amount_round_off);

                    $item->orderDetail->map(
                        function ($item2, $key2) use ($no_tax_amount_round_off) {
                            //從這裡開始遍歷每張銷貨單的細項
                            //並算出小計
                            $item2->subTotal = round($item2->quantity * $item2->no_tax_price
                                , $no_tax_amount_round_off);
                            return $item2;
                        }
                    );

                    return $item;
                })
        );
        $data = $data->merge($this->returnOfSale
                ->getFullOrderDetailByConditions($company_id, $stock_id, $start_date, $end_date)
                ->map(function ($item, $key) use (
                    $sale_tax_rate, $no_tax_amount_round_off, $tax_round_off)
                {
                    //從這裡開始遍歷每張銷貨單
                    //算出單張銷貨單的總金額, 稅額等
                    //總金額與已收金額改為負數
                    $item->total_amount = $item->total_amount * -1;

                    $item->received_amount = $item->received_amount * -1;
                    //算出稅額
                    $item->tax = round($item->total_amount * $sale_tax_rate, $tax_round_off);

                    $item->total_no_tax_amount = round($item->total_amount - $item->tax,
                         $no_tax_amount_round_off);

                    $item->orderDetail->map(
                        function ($item2, $key2) use ($no_tax_amount_round_off) {
                            //從這裡開始遍歷每張銷貨單的細項
                            //並把單價算出負數算出小計
                            $item2->no_tax_price = $item2->no_tax_price * -1;

                            $item2->subTotal = round($item2->quantity * $item2->no_tax_price
                                , $no_tax_amount_round_off);
                            return $item2;
                        }
                    );
                    return $item;
                })
        );
        return $data->sortBy('created_at');
    }

}