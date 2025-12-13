<?php

namespace App\Http\Requests\Admin;

use App\Enums\ModerationAction;
use Illuminate\Foundation\Http\FormRequest;

class ResolveModerationReportRequest extends FormRequest
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
            'action' => ['required', ModerationAction::validationRule()],
            'notes' => 'nullable|string|max:1000',
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
            'action.required' => 'Please select a moderation action.',
            'action.in' => 'Invalid moderation action selected.',
        ];
    }
}
