<?php

namespace ReceivableWriteOff;

use App\Http\Requests\Request;
use App\Contracts\FormRequestInterface;

class ReceivableWriteOffRequest extends Request implements FormRequestInterface
{

    protected $orderMasterInputName = 'receivableWriteOff';
    protected $creditInputName = 'receivableWriteOffCredit';
    protected $debitInputName = 'receivableWriteOffDebit';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
                //驗證是否有選擇供應商
                "{$this->orderMasterInputName}.company_id"
                    => "required",
                //驗證是否借貸平衡
                "{$this->orderMasterInputName}.total_credit_amount"
                    => "same:{$this->orderMasterInputName}.total_debit_amount"
        ];

        // $this->input("{$this->orderMasterInputName}.credit_total_amount") = 0;

        // $this->input("{$this->orderMasterInputName}.debit_total_amount") = 0;

        if ($this->input($this->creditInputName)
            && $this->input($this->debitInputName)) {
            $debit_min_index = min(array_keys($this->input($this->debitInputName)));
            $credit_min_index = min(array_keys($this->input($this->creditInputName)));

            //貸方借證規則
            $rules["{$this->debitInputName}.{$debit_min_index}.debit_checked"] = '';

            $debit_without_all = "required_without_all:";

            foreach ($this->input($this->debitInputName) as $key => $fields) {
                if ($key != $debit_min_index) {
                    $debit_without_all .= "{$this->debitInputName}.{$key}.debit_checked,";
                }
            }
            //驗證借方項目是否有勾選
            $rules["{$this->debitInputName}.{$debit_min_index}.debit_checked"]
                .= substr($debit_without_all, 0, -1);

            //貸方驗證規則
            $rules["{$this->creditInputName}.{$credit_min_index}.credit_checked"] = '';

            $credit_without_all = "required_without_all:";

            foreach ($this->input($this->creditInputName) as $key => $fields) {
                if ($key != $credit_min_index) {
                    $credit_without_all .= "{$this->creditInputName}.{$key}.credit_checked,";
                }

                $not_paid_amount = $this->input("{$this->creditInputName}.{$key}.credit_order_amount")
                    - $this->input("{$this->creditInputName}.{$key}.credit_received_amount");
                /**
                 * 驗證規則如下
                 * 1. 應付帳款沖銷金額應填入數字
                 * 2. 應付帳款不能超過未付清款項
                 * 3. 如果有勾選才需要填入金額
                 */
                foreach ($fields as $key2 => $value) {
                    $rules["{$this->creditInputName}.{$key}.credit_amount"]
                        = "numeric|max:{$not_paid_amount}|required_if:{$this->creditInputName}.{$key}.credit_checked, 1";
                }
            }
            //驗證借方項目是否有勾選
            $rules["{$this->creditInputName}.{$credit_min_index}.credit_checked"]
                .= substr($credit_without_all, 0, -1);

        }

        return $rules;
    }
}
