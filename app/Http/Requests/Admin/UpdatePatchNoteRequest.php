<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatchNoteRequest extends FormRequest
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
            'game_name' => 'required|string|max:255',
            'version' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'source_url' => 'nullable|url|max:500',
            'released_at' => 'nullable|date',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
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
            'game_name.required' => 'Game name is required.',
            'title.required' => 'Patch note title is required.',
            'content.required' => 'Patch note content is required.',
            'source_url.url' => 'Source URL must be a valid URL.',
        ];
    }
}
