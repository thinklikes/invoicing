<?php

namespace App\Http\Requests\Purchase;

use App\Http\Requests\Request;
use App\Contracts\FormRequestInterface;

class PaymentRequest extends Request implements FormRequestInterface
{
    protected $orderMasterInputName = 'payment';
    protected $table_name           = 'payment';
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
                //表頭驗證規則
                // "{$this->orderMasterInputName}.code"
                //     => "required|unique:{$this->table_name},code,{$code},code",
                "{$this->orderMasterInputName}.pay_date" => "date|required",
                "{$this->orderMasterInputName}.supplier_id" => "required",
                "{$this->orderMasterInputName}.check_code"
                    => "required_if:{$this->orderMasterInputName}.type,check",
                "{$this->orderMasterInputName}.expiry_date"
                    => "date|required_if:{$this->orderMasterInputName}.type,check",
                "{$this->orderMasterInputName}.bank_account"
                    => "required_if:{$this->orderMasterInputName}.type,check",
                "{$this->orderMasterInputName}.amount" => "numeric|required"
                // "{$this->orderMasterInputName}.tax_rate_code"
                //     => "required",
        ];
        return $rules;
    }
}
