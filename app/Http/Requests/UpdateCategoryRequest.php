<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $category = $this->route('category');

        return [
            'name'        => ['required', 'string', 'max:100', Rule::unique('categories', 'name')->ignore($category->id)],
            'description' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Collection ka naam zaroori hai.',
            'name.unique'   => 'Ye collection pehle se maujood hai.',
            'name.max'      => 'Naam 100 characters se zyada nahi ho sakta.',
        ];
    }
}