<?php

namespace App\Http\Requests;

interface RequestInterface
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules();
}