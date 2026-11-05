<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:150',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'art'         => 'nullable|string|max:50',
            'compare_price' => 'nullable|numeric|min:0|gt:price',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'category required.',
            'category_id.exists'   => 'Selected category does not exist.',
            'name.required'        => 'Product name is required.',
            'price.required'       => 'Price is required.',
            'price.numeric'        => 'Price must be a number.',
            'stock.required'       => 'Stock is required.',
            'image.image'          => 'image file is required.',
            'image.mimes'          => 'image must be a JPG, PNG, or WEBP file.',
            'image.max'            => 'image must be less than 2 MB.',
        ];
    }
}