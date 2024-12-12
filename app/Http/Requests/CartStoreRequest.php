<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CartStoreRequest extends FormRequest
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
            'product_id' => 'required|numeric|exists:products,id',
            'quantity' => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'product_id.required' => 'Product is required',
            'product_id.numeric' => 'product id must be an int value',
            'product_id.exists' => 'select a valid product id',
            'quantity.required' => 'Quantity is required',
            'quantity.numeric' => 'product id must be an int value',
        ];
    }
}
