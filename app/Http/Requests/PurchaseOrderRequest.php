<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use App\Contracts\FormRequestInterface;

class PurchaseOrderRequest extends Request implements FormRequestInterface
{
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
        $code = $this->input('purchase_order_master.code');

        $rules = [
                //採購單表頭驗證規則
                'purchase_order_master.code'
                    => 'required|unique:purchase_order_master,code,'.$code.',code',
                'purchase_order_master.supplier_code'
                    => 'required',
                'purchase_order_master.tax_rate_code'
                    => 'required',
        ];

        $min_index = min(array_keys($this->input('purchase_order_detail')));
        $rules_stock = '|required_without_all:';
        foreach ($this->input('purchase_order_detail') as $key => $fields) {
            if ($key != $min_index) {
                $rules_stock .= "purchase_order_detail.$key.stock_id,";
            }
            foreach ($fields as $key2 => $value) {

                $rules['purchase_order_detail.'."$key.stock_id"]
                    = 'required_unless:purchase_order_detail.'.$key.'.quantity,0,""';

                $rules['purchase_order_detail.'."$key.quantity"]
                    = 'numeric|required_with:purchase_order_detail.'.$key.'.stock_id';

                $rules['purchase_order_detail.'."$key.no_tax_price"] = 'numeric';


            }
        }
        $rules['purchase_order_detail.'."$min_index.stock_id"] .= substr($rules_stock, 0, -1);

        return $rules;
    }
}
