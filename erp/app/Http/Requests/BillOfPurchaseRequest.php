<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BillOfPurchaseRequest extends Request implements RequestInterface
{
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
        $code = $this->input('billOfPurchaseMaster.code');

        $rules = [
                //採購單表頭驗證規則
                'billOfPurchaseMaster.code'
                    => 'required|unique:bill_of_purchase_master,code,'.$code.',code',
                'billOfPurchaseMaster.supplier_id'
                    => 'required',
                'billOfPurchaseMaster.tax_rate_code'
                    => 'required',
                'billOfPurchaseMaster.warehouse_id'
                    => 'required',
        ];

        $min_index = min(array_keys($this->input('billOfPurchaseDetail')));
        $rules_stock = '|required_without_all:';
        foreach ($this->input('billOfPurchaseDetail') as $key => $fields) {
            if ($key != $min_index) {
                $rules_stock .= "billOfPurchaseDetail.$key.stock_id,";
            }
            foreach ($fields as $key2 => $value) {

                $rules['billOfPurchaseDetail.'."$key.stock_id"]
                    = 'required_unless:billOfPurchaseDetail.'.$key.'.quantity,0,""';

                $rules['billOfPurchaseDetail.'."$key.quantity"]
                    = 'numeric|required_with:billOfPurchaseDetail.'.$key.'.stock_id';

                $rules['billOfPurchaseDetail.'."$key.no_tax_price"] = 'numeric';


            }
        }
        $rules['billOfPurchaseDetail.'."$min_index.stock_id"] .= substr($rules_stock, 0, -1);

        return $rules;
    }
}
