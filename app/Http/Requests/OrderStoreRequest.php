<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderStoreRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    public function authorize(): bool
    {
        return true;
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => $validator->errors()->first()
        ], 422));
    }
    public function rules(): array
    {
        return [
            'cart_id' => 'required|numeric|exists:carts,id',
        ];
    }
    public function messages()
    {
        return [
            'cart_id.required' => 'Cart id is required',
            'cart_id.numeric' => 'Cart id id must be an int value',
            'cart_id.exists' => 'select a valid cart id',
        ];
    }
}
