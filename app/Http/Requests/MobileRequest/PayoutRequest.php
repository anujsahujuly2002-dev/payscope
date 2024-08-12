<?php

namespace App\Http\Requests\MobileRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PayoutRequest extends FormRequest
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
            'account_number' => 'required',
            'ifsc_code' => 'required',
            'account_holder_name' => 'required',
            'amount' => 'required',
            'payment_mode' => 'required',
            'bank_name' => 'required',
            'branch_name' => 'required',
            'remark' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'status'=>false,
            'errors' => $validator->errors(),
        ], 422));
    }
}
