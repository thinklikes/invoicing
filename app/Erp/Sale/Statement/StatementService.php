<?php
namespace Statement;

use Company\CompanyRepository as Company;
use BillOfSale\BillOfSaleRepository as BillOfSale;
use ReturnOfSale\ReturnOfSaleRepository as ReturnOfSale;
use Illuminate\Support\MessageBag;
use App;

class StatementService
{
    protected $billOfSale;
    protected $returnOfSale;
    protected $company;

    public function __construct(
        BillOfSale $billOfSale,
        ReturnOfSale $returnOfSale,
        Company $company)
    {
        $this->billOfSale  = $billOfSale;
        $this->returnOfSale = $returnOfSale;
        $this->company = $company;
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
    public function getStatementByCompanyId(
        $company_id = '', $start_date = '', $end_date = '')
    {
        $data = collect([]);

        $sale_tax_rate = config('system_configs.sale_tax_rate');
        $no_tax_amount_round_off = config('system_configs.no_tax_amount_round_off');
        $tax_round_off = config('system_configs.tax_round_off');

        //抓出這個客戶ID的銷貨單應收帳款
        $data = $data->merge(
            $this->billOfSale
                ->getReceivableByCompanyId($company_id, $start_date, $end_date)
                ->map(function ($item, $key) use (
                    $sale_tax_rate,
                    $no_tax_amount_round_off,
                    $tax_round_off) {
                    //計算未稅金額與稅額
                    $item->tax = round($item->total_amount * $sale_tax_rate, $tax_round_off);

                    $item->total_no_tax_amount = round($item->total_amount - $item->tax,
                         $no_tax_amount_round_off);
                    return $item;
                })
        );

        //抓出這個客戶ID的銷貨退回單應收帳款
        $data = $data->merge(
            $this->returnOfSale
                ->getReceivableByCompanyId($company_id, $start_date, $end_date)
                ->map(function ($item, $key) use (
                    $sale_tax_rate,
                    $no_tax_amount_round_off,
                    $tax_round_off) {
                    //在這裡遍歷每一項銷貨退回單應收帳款，
                    //將總金額與已收金額改為負數
                    $item->total_amount = $item->total_amount * -1;

                    $item->received_amount = $item->received_amount * -1;

                    $item->tax = round($item->total_amount * $sale_tax_rate, $tax_round_off);

                    $item->total_no_tax_amount = round($item->total_amount - $item->tax,
                         $no_tax_amount_round_off);
                    return $item;
                })
        );
        return $data->sortBy('created_at');
    }

}