<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ResolvePredictionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->hasRole('Administrator');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'correct_option_index' => 'required|integer|min:0',
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
            'correct_option_index.required' => 'Please select the correct option.',
            'correct_option_index.integer' => 'Correct option must be a valid number.',
            'correct_option_index.min' => 'Correct option index must be at least 0.',
        ];
    }
}
