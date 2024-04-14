<?php

namespace App\Http\Requests\Products;

use App\Http\Requests\Request;

class CreateProductRequest extends Request
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'product title',
            'description' => 'product description',
            'price' => 'product price',
        ];
    }
}
