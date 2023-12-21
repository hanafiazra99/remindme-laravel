<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\ApiResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        // $api_response = new ApiResponse;
        // $response = $api_response->error($validator->errors(),'validation_error',422);
        // throw new HttpResponseException($response);

        abort(400);
    }   

    
}
