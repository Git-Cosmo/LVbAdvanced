<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePredictionRequest extends FormRequest
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
            'description' => 'nullable|string',
            'category' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'points_reward' => 'required|integer|min:1',
            'closes_at' => 'required|date|after:now',
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
            'title.required' => 'Prediction title is required.',
            'category.required' => 'Category is required.',
            'options.required' => 'Prediction options are required.',
            'options.min' => 'At least 2 options are required.',
            'options.*.required' => 'Each option must have a value.',
            'points_reward.required' => 'Points reward is required.',
            'points_reward.min' => 'Points reward must be at least 1.',
            'closes_at.required' => 'Closing date is required.',
            'closes_at.after' => 'Closing date must be in the future.',
        ];
    }
}
