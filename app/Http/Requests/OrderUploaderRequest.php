<?php

namespace App\Http\Requests;

use Carbon\Carbon;

class OrderUploaderRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //非Demo使用者才能新增與更新
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
            //驗證規則
            "orderUploader.platform_name" => "required",
            //"orderUploader.upload_file" => "required|mimes:xls,csv,xlsx",
        ];

        return $rules;
    }
}
