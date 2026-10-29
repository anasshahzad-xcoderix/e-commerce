<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'choose the category.',
            'category_id.exists'   => 'this does not exist.',
            'name.required'        => 'product name is required.',
            'price.required'       => 'product price is required.',
            'price.numeric'        => 'price always in the number.',
            'stock.required'       => 'product stock is required.',
            'image.image'          => 'upload only image file.',
            'image.mimes'          => 'Image only is jpg,png.',
            'image.max'            => 'Image size is always contain 2 MB .',
        ];
    }
}
