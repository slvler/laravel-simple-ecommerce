<?php

namespace App\Http\Requests;

use App\Enums\ProductStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
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
            'name' => 'nullable',
            'price' => 'nullable|numeric',
            'stock' => 'nullable|numeric',
            'status' => ['nullable', Rule::in([ProductStatus::DRAFT->name, ProductStatus::ACTIVE->name, ProductStatus::ARCHIVED->name])],
        ];
    }

}
