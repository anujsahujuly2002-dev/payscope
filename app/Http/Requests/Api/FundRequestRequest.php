<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class FundRequestRequest extends FormRequest
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
            
            'account_number'=>'required|numeric|min:10',
            'bank_name'=>'required',
            'account_holder_name'=>'required|string|min:3',
            'ifsc_code'=>'required|ifsc',
            'amount'=>'required|min:10|numeric',
            'payment_mode'=>'required',
            'creditor_email'=>'required',
            'creditor_mobile'=>'required',
        ];
    }

    /**
        * Get the error messages for the defined validation rules.*
        * @return array
    */
    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'status'=>false,
            'msg' => $validator->errors()->first(),
        ], 422));
    }

}
