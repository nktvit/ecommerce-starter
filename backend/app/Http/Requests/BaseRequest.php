<?php

namespace App\Http\Requests;

use App\Traits\HttpResponses;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    use HttpResponses;

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->error($validator->errors(), '', 422));
    }
}
