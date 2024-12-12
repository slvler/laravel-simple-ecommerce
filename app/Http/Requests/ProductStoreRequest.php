<?php

namespace App\Http\Requests;

use App\Enums\ProductStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'status' => ['required', Rule::in([ProductStatus::DRAFT->name, ProductStatus::ACTIVE->name, ProductStatus::ARCHIVED->name])],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'price.required' => 'Price is required',
            'stock.required' => 'Stock is required',
            'status.required' => 'Status is required',
        ];
    }
}
