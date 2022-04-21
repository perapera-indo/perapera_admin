<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $message = 'Insert';
        if($this->isMethod('PUT')){
            $message = 'Update';
        }
        request()->session()->flash('error', 'Failed '.$message.' data!');
        return parent::failedValidation($validator);
    }
}
