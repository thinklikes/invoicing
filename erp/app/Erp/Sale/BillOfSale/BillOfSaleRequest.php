<?php

namespace BillOfSale;

use App\Http\Requests\Request;
use App\Contracts\FormRequestInterface;
use Carbon\Carbon;

class BillOfSaleRequest extends Request implements FormRequestInterface
{

    protected $masterInputName = 'billOfSaleMaster';
    protected $detailInputName = 'billOfSaleDetail';
    protected $table_name      = 'bill_of_purchase_master';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //非Demo使用者才能新增與更新
        return !$this->user()->can('isDemoUser');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $lastDayOfPrevMonth = Carbon::now()->subMonth()
            ->format('Y-m-01');

        $rules = [
                //表頭驗證規則
                "{$this->masterInputName}.date"
                    => "required|date|after:".$lastDayOfPrevMonth,
                "{$this->masterInputName}.company_id"
                    => "required",
                // "{$this->masterInputName}.tax_rate_code"
                //     => "required",
                "{$this->masterInputName}.warehouse_id"
                    => "required",
        ];

        if ($this->input($this->detailInputName)) {
            $code = $this->input("$this->masterInputName.code");
            $min_index = min(array_keys($this->input($this->detailInputName)));
            $rules_stock = "|required_without_all:";
            foreach ($this->input($this->detailInputName) as $key => $fields) {
                if ($key != $min_index) {
                    $rules_stock .= "{$this->detailInputName}.{$key}.stock_id,";
                }
                foreach ($fields as $key2 => $value) {

                    $rules["{$this->detailInputName}.{$key}.stock_id"]
                        = "required_unless:{$this->detailInputName}.{$key}.quantity,0,\"\"";

                    $rules["{$this->detailInputName}.{$key}.quantity"]
                        = "numeric|required_with:{$this->detailInputName}.{$key}.stock_id";

                    $rules["{$this->detailInputName}.{$key}.no_tax_price"]
                        = 'numeric';
                }
            }
            $rules["{$this->detailInputName}.{$min_index}.stock_id"]
                .= substr($rules_stock, 0, -1);
        }

        return $rules;
    }
}
