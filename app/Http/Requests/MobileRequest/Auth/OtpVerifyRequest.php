<?php

namespace App\Http\Requests\MobileRequest\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OtpVerifyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            
            'otp'=>'required|digits:4',
        ];
    }

    /**
        * Get the error messages for the defined validation rules.*
        * @return array
    */
    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'status'=>false,
            'errors' => $validator->errors(),
        ], 422));
    }
}
