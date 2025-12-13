<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'game' => 'required|max:100',
            'category' => 'required|in:map,skin,mod,texture,sound,other',
            'files.*' => 'required|file|max:102400', // 100MB max
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
            'title.required' => 'Title is required.',
            'game.required' => 'Game is required.',
            'category.required' => 'Category is required.',
            'category.in' => 'Invalid category selected.',
            'files.*.required' => 'At least one file is required.',
            'files.*.file' => 'Uploaded item must be a file.',
            'files.*.max' => 'File size cannot exceed 100MB.',
        ];
    }
}
