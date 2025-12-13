<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
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
            'xp' => 'nullable|integer|min:0',
            'level' => 'nullable|integer|min:1',
            'karma' => 'nullable|integer',
            'user_title' => 'nullable|string|max:255',
            'about_me' => 'nullable|string',
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
            'xp.integer' => 'XP must be a valid number.',
            'xp.min' => 'XP cannot be negative.',
            'level.integer' => 'Level must be a valid number.',
            'level.min' => 'Level must be at least 1.',
        ];
    }
}
