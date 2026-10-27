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
            'category_id.required' => 'Collection chunna zaroori hai.',
            'category_id.exists'   => 'Chuni hui collection maujood nahi hai.',
            'name.required'        => 'Product ka naam zaroori hai.',
            'price.required'       => 'Price zaroori hai.',
            'price.numeric'        => 'Price number honi chahiye.',
            'stock.required'       => 'Stock zaroori hai.',
            'image.image'          => 'Sirf image file upload karein.',
            'image.mimes'          => 'Image JPG, PNG ya WEBP honi chahiye.',
            'image.max'            => 'Image 2 MB se choti honi chahiye.',
        ];
    }
}