<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
   
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', 'max:150'],
            'phone'     => ['required', 'string', 'max:20'],
            'area'      => ['required', 'string', 'max:150'],
            'block'     => ['required', 'string', 'max:20'],
            'street'    => ['required', 'string', 'max:150'],
            'building'  => ['required', 'string', 'max:50'],
            'floor'     => ['nullable', 'string', 'max:20'],
            'apartment' => ['nullable', 'string', 'max:20'],
            'paci'      => ['nullable', 'string', 'max:20'],
            'notes'     => ['nullable', 'string', 'max:5000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'This field is required.',
            'email.email' => 'Please enter a valid email address.',
            

        ];
    }
}
