<?php

namespace StockAdjust;

use App\Http\Requests\Request;
use App\Contracts\FormRequestInterface;
use Carbon\Carbon;

class StockAdjustRequest extends Request implements FormRequestInterface
{

    protected $orderMasterInputName = 'stockAdjustMaster';
    protected $orderDetailInputName = 'stockAdjustDetail';

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
            ->format('Y-m-t');

        $rules = [
            "{$this->orderMasterInputName}.date"
                => "required|date|after:".$lastDayOfPrevMonth,
            //表頭驗證規則
            "{$this->orderMasterInputName}.warehouse_id"
                => "required",
        ];


        if ($this->input($this->orderDetailInputName)) {
            $code = $this->input("$this->orderMasterInputName.code");
            $min_index = min(array_keys($this->input($this->orderDetailInputName)));
            $rules_stock = "|required_without_all:";
            foreach ($this->input($this->orderDetailInputName) as $key => $fields) {
                if ($key != $min_index) {
                    $rules_stock .= "{$this->orderDetailInputName}.{$key}.stock_id,";
                }
                foreach ($fields as $key2 => $value) {

                    $rules["{$this->orderDetailInputName}.{$key}.stock_id"]
                        = "required_unless:{$this->orderDetailInputName}.{$key}.quantity,0,\"\"";

                    $rules["{$this->orderDetailInputName}.{$key}.quantity"]
                        = "numeric|required_with:{$this->orderDetailInputName}.{$key}.stock_id";

                    $rules["{$this->orderDetailInputName}.{$key}.no_tax_price"]
                        = 'numeric';
                }
            }
            $rules["{$this->orderDetailInputName}.{$min_index}.stock_id"]
                .= substr($rules_stock, 0, -1);
        }

        return $rules;
    }
}
