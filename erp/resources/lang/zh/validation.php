<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'filled'               => 'The :attribute field is required.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        //系統設定的表單驗證訊息
        'configs' => [
            'website_title' => [
                'required' => '我們需要知道網站名稱！',
            ],
            'system_build_date' => [
                'required' => '我們需要知道系統建立日期！',
            ],
        ],

        //全系統通用的表單驗證訊息
        '*' => [
            'date' => [
                'required' => '我們需要知道開單日期!!',
                'date' => '開單日期請填入正確格式(YYYY-MM-dd)',
                'after' => '請輸入本月的日期區間',
            ],
            'email' => [
                'email'          => '電子郵件請輸入正確的格式',
            ],
            'zip' => [
                'integer'        => '郵遞區號請填入數字',
                'digits_between' => '郵遞區號最多5碼',
            ],
            'address' => [
                'required'       => '我們需要知道地址',
            ],
            'telphone' => [
                'required'       => '我們需要知道電話號碼',
            ],
            'taxNumber' => [
                'required'       => '我們需要知道統一編號',
                'digits'         => '統一編號請填入八位數字',
            ],
            'pay_way_id' => [
                'required' => '我們需要知道付款方式',
            ],
            'tax_rate_code' => [
                'required' => '我們需要知道營業稅別!!',
            ],
            'supplier_id' => [
                'required' => '我們需要知道供應商',
            ],
            'company_id' => [
                'required' => '我們需要知道客戶',
            ],
            'warehouse_id' => [
                'required' => '我們需要知道使用倉庫',
            ],
            'stock_id' => [
                'required_unless'      => '我們需要知道料品名稱!!',
                'required_without_all' => '請至少輸入一項料品',
            ],
            'quantity' => [
                'required_with' => '我們需要知道數量!!',
                'numeric'       => '數量請填入數字',
            ],
            'no_tax_price' => [
                'numeric' => '稅前單價請填入數字',
            ],
        ],
        //客戶資料管理的表單驗證訊息
        'customer' => [
            'name' => [
                'required'       => '我們需要知道公司名稱',
            ],
        ],
        'supplier' => [
            'code' => [
                'required'       => '我們需要知道供應商編號',
            ],
            'name' => [
                'required'       => '我們需要知道供應商名稱',
            ],
        ],
        'stock' => [
            'code' => [
                'required'       => '我們需要知道料品代號',
            ],
            'name' => [
                'required'       => '我們需要知道料品名稱',
            ],
            'net_weight' => [
                'required'       => '我們需要知道料品淨重',
            ],
            'gross_weight' => [
                'required'       => '我們需要知道料品毛重',
            ],
        ],
        'unit' => [
            'code'        => [
                'required' => '我們需要知道單位代號',
            ],
            'comment'        => [
                'required' => '我們需要知道單位說明',
            ],
        ],
        'stock_class' => [
            'code'        => [
                'required' => '我們需要知道料品類別代號',
            ],
            'comment'        => [
                'required' => '我們需要知道料品類別說明',
            ],
        ],
        'warehouse' => [
            'code'        => [
                'required' => '我們需要知道倉庫代號',
            ],
            'comment'        => [
                'required' => '我們需要知道倉庫說明',
            ],
        ],
        'pay_way' => [
            'code'        => [
                'required' => '我們需要知道付款方式代號',
            ],
            'comment'        => [
                'required' => '我們需要知道付款方式說明',
            ],
        ],
        'purchase_order_master'=> [
            'code' => [
                'required' => '我們需要知道採購單號!!',
                'unique'   => '這一組採購單號已使用了!!',
            ],
            'delivery_date' => [
                'required' => '我們需要知道交貨日期!!',
                'date'     => '交貨日期請輸入正確的日期格式(YYYY-MM-dd)',
                'after'    => '交貨日期須設定為今天以後!!',
            ],
            'supplier_code' => [
                'required' => '我們需要知道供應商',
            ],
            'tax_rate_code' => [
                'required' => '我們需要知道營業稅別!!',
            ],
        ],
        'purchase_order_detail'=> [
            '*' => [
                'quantity' => [
                    'required_with' => '我們需要知道數量!!',
                    'numeric'       => '數量請填入數字',
                ],
                'no_tax_price' => [
                    'numeric' => '稅前單價請填入數字',
                ],
            ],
        ],
        'payment'=> [
            'pay_date' => [
                'required' => '我們需要知道付款日期',
                'date'     => '付款日期請輸入正確的日期格式(YYYY-MM-dd)',
            ],
            'check_code' => [
                'required_if' => '我們需要知道票據號碼',
            ],
            'expiry_date' => [
                'required_if' => '我們需要知道到期日',
                'date'        => '到期日請輸入正確的日期格式(YYYY-MM-dd)',
            ],
            'bank_account' => [
                'required_if' => '我們需要知道銀行帳號',
            ],
            'amount' => [
                'required' => '我們需要知道付款金額',
                'numeric'  => '付款金額請填入數值',
            ],
        ],
        'payableWriteOff' => [
            'total_credit_amount' => [
                'same' => '應付帳款沖銷不平，請檢查沖銷金額!!'
            ]
        ],
        'payableWriteOffCredit' => [
            '*' => [
                'credit_checked' => [
                    'required_without_all' => '請至少沖銷一項付款金額',
                ],
            ],
        ],
        'payableWriteOffDebit' => [
            '*' => [
                'debit_checked' => [
                    'required_without_all' => '請至少沖銷一項應付帳款',
                ],
                'debit_amount' => [
                    'numeric' => '應付帳款沖銷金額請填入數字',
                    'max'     => '應付帳款沖銷金額高於未付清款項',
                    'required_if' => '我們需要知道應付帳款沖銷金額'
                ],
            ],
            // '0' => [
            //     'debit_checked' => [
            //         'required' => '請選擇供應商，或聯絡管理員',
            //     ],
            // ]
        ],
        'receipt'=> [
            'receive_date' => [
                'required' => '我們需要知道收款日期',
                'date'     => '收款日期請輸入正確的日期格式(YYYY-MM-dd)',
            ],
            'check_code' => [
                'required_if' => '我們需要知道票據號碼',
            ],
            'expiry_date' => [
                'required_if' => '我們需要知道到期日',
                'date'        => '到期日請輸入正確的日期格式(YYYY-MM-dd)',
            ],
            'bank_account' => [
                'required_if' => '我們需要知道銀行帳號',
            ],
            'amount' => [
                'required' => '我們需要知道收款金額',
                'numeric'  => '收款金額請填入數值',
            ],
        ],
        'receivableWriteOff' => [
            'total_credit_amount' => [
                'same' => '應收帳款沖銷不平，請檢查沖銷金額!!'
            ]
        ],
        'receivableWriteOffCredit' => [
            '*' => [
                'credit_checked' => [
                    'required_without_all' => '請至少沖銷一項應收帳款',
                ],
                'credit_amount' => [
                    'numeric' => '應收帳款沖銷金額請填入數字',
                    'max'     => '應收帳款沖銷金額高於未收款金額',
                    'required_if' => '我們需要知道應收帳款沖銷金額'
                ],
            ],
        ],
        'receivableWriteOffDebit' => [
            '*' => [
                'debit_checked' => [
                    'required_without_all' => '請至少沖銷一項收款金額',
                ],
            ],
            // '0' => [
            //     'debit_checked' => [
            //         'required' => '請選擇供應商，或聯絡管理員',
            //     ],
            // ]
        ],
        'stockTransferMaster' => [
            'from_warehouse_id' => [
                'required' => '我們需要知道調出倉庫',
                'different' => '請選擇相互不同的調出調入倉庫'
            ],
            'to_warehouse_id' => [
                'required' => '我們需要知道調入倉庫'
            ]
        ]
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
