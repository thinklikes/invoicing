<?php

namespace App\Http\Requests;

use App\Contracts\FormRequestInterface;

class ErpRequest extends Request implements FormRequestInterface
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
        //找出傳遞過來的陣列key值，並抓出來做為一維陣列
        $indexes = array_keys($this->input());

        //找出值為_token的key值
        $key = array_keys($indexes, '_token');

        //排除_token
        if (!empty($key)) {
            //排除_method
            array_forget($indexes, $key[0]);
        }

        //找出值為_method的key值
        $key = array_keys($indexes, '_method');

        if (!empty($key)) {
            //排除_method
            array_forget($indexes, $key[0]);
        }

        $rules = [
            //客戶資料表單驗證規則
            'company' => [
                'company_code' => 'required',
                'company_name' => 'required',
                //'boss'         => 'required',
                'company_add'  => 'required',
                'company_tel'  => 'required',
                //'VTA_NO'       => 'required|digits:8',
                // 'tax_rate_id' => 'required',
                // 'pay_way_id'  => 'required',
            ],

            //供應商資料表單驗證規則
            'supplier' => [
                'code'        => 'required',
                'name'        => 'required',
                'email'       => 'email',
                'zip'         => 'integer|digits_between:0,5',
                'address'     => 'required',
                'telphone'    => 'required',
                'taxNumber'   => 'required|digits:8',
            ],

            //付款方式資料表單驗證規則
            'pay_way'  => [
                'code'    => 'required',
                'comment' => 'required',
            ],

            //料品資料表單驗證規則
            'stock'    => [
                'code'        => 'required',
                'name'        => 'required',
                // 'net_weight'   => 'required',
                // 'gross_weight' => 'required',
            ],

            //系統設定資料表單驗證規則
            'configs'  => [
                'website_title'     => 'required',
                'system_build_date' => 'required',
            ],

            //料品單位資料表單驗證規則
            'unit'     => [
                'code'        => 'required',
                'comment'     => 'required',
            ],

            //料品類別資料表單驗證規則
            'stock_class'     => [
                'code'        => 'required',
                'comment'     => 'required',
            ],

            //倉庫資料表單驗證規則
            'warehouse'     => [
                'code'        => 'required',
                'name'     => 'required',
            ],
        ];

        $return_rules = array();
        foreach ($indexes as $uri) {
            foreach ($rules[$uri] as $input => $rule) {
                $return_rules[$uri.".".$input] = $rule;
            }
        }
        //dd($return_rules);
        return $return_rules;
    }
}