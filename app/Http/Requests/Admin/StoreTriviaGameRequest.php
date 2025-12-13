<?php

namespace App\Http\Requests\Admin;

use App\Enums\TriviaGameDifficulty;
use Illuminate\Foundation\Http\FormRequest;

class StoreTriviaGameRequest extends FormRequest
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
            'difficulty' => ['required', TriviaGameDifficulty::validationRule()],
            'time_limit' => 'required|integer|min:10|max:300',
            'points_per_correct' => 'required|integer|min:1',
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
            'title.required' => 'Trivia game title is required.',
            'category.required' => 'Category is required.',
            'difficulty.required' => 'Difficulty level is required.',
            'difficulty.in' => 'Invalid difficulty level selected. Choose easy, medium, or hard.',
            'time_limit.required' => 'Time limit is required.',
            'time_limit.min' => 'Time limit must be at least 10 seconds.',
            'time_limit.max' => 'Time limit cannot exceed 300 seconds.',
            'points_per_correct.required' => 'Points per correct answer is required.',
            'points_per_correct.min' => 'Points per correct answer must be at least 1.',
        ];
    }
}
