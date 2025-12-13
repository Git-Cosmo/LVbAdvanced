<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
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
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'source' => 'nullable|string|max:255',
            'source_url' => 'nullable|url|max:500',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|string',
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
            'title.required' => 'News title is required.',
            'content.required' => 'News content is required.',
            'image.image' => 'The uploaded file must be an image.',
            'image.max' => 'The image size cannot exceed 2MB.',
        ];
    }
}
