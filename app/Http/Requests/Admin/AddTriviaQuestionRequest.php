<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddTriviaQuestionRequest extends FormRequest
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
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_answer_index' => 'required|integer|min:0',
            'explanation' => 'nullable|string',
            'points' => 'required|integer|min:1',
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
            'question.required' => 'Question text is required.',
            'options.required' => 'Answer options are required.',
            'options.min' => 'At least 2 answer options are required.',
            'options.*.required' => 'Each option must have a value.',
            'correct_answer_index.required' => 'Correct answer index is required.',
            'correct_answer_index.integer' => 'Correct answer index must be a number.',
            'correct_answer_index.min' => 'Correct answer index must be at least 0.',
            'points.required' => 'Points value is required.',
            'points.min' => 'Points must be at least 1.',
        ];
    }
}
