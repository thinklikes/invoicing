<?php

namespace Erp\Requests;

use App\Http\Requests\Request;
use App\Contracts\FormRequestInterface;
use Erp\Services\UserService;

class UserRequest extends Request implements FormRequestInterface
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
        $rules = [];
        $required = UserService::$required;

        foreach ($required['head'] as $key => $value) {
            $rules['user.'.$value] = 'required';
        }

        $rules['user.password'] .= "|same:user.password2";
        return $rules;
    }
}
