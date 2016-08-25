<?php
namespace SaleReport;

use BillOfSale\BillOfSaleRepository as BillOfSale;
use ReturnOfSale\ReturnOfSaleRepository as ReturnOfSale;
use Illuminate\Support\MessageBag;
use App\Libaries\OrderCalculator;
use App;
use DB;

class SaleReportService
{
    private $billOfSale;
    private $returnOfSale;
    private $calculator;

    public function __construct(
        BillOfSale $billOfSale,
        ReturnOfSale $returnOfSale,
        OrderCalculator $calculator)
    {
        $this->billOfSale  = $billOfSale;
        $this->returnOfSale = $returnOfSale;
        $this->calculator = $calculator;
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
     * 用客戶的id取得銷貨記錄，並且以date來排序
     * @param  integer $stock_id     料品的ID
     * @param  string $start_date    查詢的起始日期
     * @param  string $end_date      查詢的結束日期
     * @return Collection            包含了型別為 StockInLogs或StockOutLogs的資料
     */
    public function getSaleReportByConditions(
        $company_id = '',
        $stock_id = '',
        $start_date = '',
        $end_date = '')
    {
        $data = collect([]);

        $data = $data->merge($this->billOfSale
                ->getFullOrderDetailByConditions($company_id, $stock_id, $start_date, $end_date)
                ->map(function ($item, $key)
                {
                    //從這裡開始遍歷每張銷貨單
                    //算出單張銷貨單的總金額, 稅額等
                    $this->calculator->setValuesAndCalculate([
                        'tax_rate_code' => $item->tax_rate_code,
                        'quantity'     => $item->orderDetail->pluck('quantity'),
                        'no_tax_price' => $item->orderDetail->pluck('no_tax_price'),
                    ]);

                    $item->tax = $this->calculator->getTax();

                    $item->total_no_tax_amount = $this->calculator->getTotalNoTaxAmount();

                    $item->total_amount = $this->calculator->getTotalAmount();

                    $item->orderDetail->map(
                        function ($item2, $key2) {
                            //從這裡開始遍歷每張銷貨單的細項
                            //並算出小計
                            $item2->subTotal = $this->calculator->getNoTaxAmount($key2);
                            return $item2;
                        }
                    );

                    return $item;
                })
        );
        $data = $data->merge($this->returnOfSale
                ->getFullOrderDetailByConditions($company_id, $stock_id, $start_date, $end_date)
                ->map(function ($item, $key)
                {
                    //從這裡開始遍歷每張銷貨單
                    //算出單張銷貨單的總金額, 稅額等
                    //總金額與已收金額改為負數
                    $this->calculator->setValuesAndCalculate([
                        'tax_rate_code' => $item->tax_rate_code,
                        'quantity'     => $item->orderDetail->pluck('quantity'),
                        'no_tax_price' => $item->orderDetail->pluck('no_tax_price'),
                    ]);

                    $item->total_amount = $this->calculator->getTotalAmount() * -1;

                    //算出稅額
                    $item->tax = $this->calculator->getTax() * -1;

                    $item->total_no_tax_amount = $this->calculator->getTotalNoTaxAmount() * -1;

                    $item->orderDetail->map(
                        function ($item2, $key2) {
                            //從這裡開始遍歷每張銷貨單的細項
                            //並把單價算出負數算出小計
                            $item2->no_tax_price = $item2->no_tax_price * -1;

                            $item2->subTotal = $this->calculator->getNoTaxAmount($key2) * -1;

                            return $item2;
                        }
                    );
                    return $item;
                })
        );
        return $data->sortBy('date');
    }

}