<?php

namespace App\Contracts;

interface FormRequestInterface
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules();
}