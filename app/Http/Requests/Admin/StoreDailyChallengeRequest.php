<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDailyChallengeRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'challenge_type' => 'required|string',
            'requirements' => 'required|array',
            'points_reward' => 'required|integer|min:1',
            'valid_date' => 'required|date',
            'is_active' => 'boolean',
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
            'title.required' => 'Challenge title is required.',
            'description.required' => 'Challenge description is required.',
            'challenge_type.required' => 'Challenge type is required.',
            'requirements.required' => 'Challenge requirements are required.',
            'requirements.array' => 'Requirements must be an array.',
            'points_reward.required' => 'Points reward is required.',
            'points_reward.min' => 'Points reward must be at least 1.',
            'valid_date.required' => 'Valid date is required.',
            'valid_date.date' => 'Valid date must be a valid date.',
        ];
    }
}
