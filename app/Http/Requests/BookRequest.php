<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
        return [
            'name'         => 'required|string|max:255|unique:books,name',
            'description'  => 'nullable|string',
            'published_at' => 'nullable|date|before_or_equal:today',
        ];
    }
}