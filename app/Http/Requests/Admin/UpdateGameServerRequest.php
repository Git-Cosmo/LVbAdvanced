<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameServerRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'game' => 'required|string|max:255',
            'game_short_code' => 'required|string|max:10',
            'description' => 'nullable|string',
            'ip_address' => 'nullable|string|max:255',
            'port' => 'nullable|integer|min:1|max:65535',
            'connect_url' => 'nullable|string|max:500',
            'status' => 'required|in:online,offline,maintenance,coming_soon',
            'max_players' => 'nullable|integer|min:0',
            'current_players' => 'nullable|integer|min:0',
            'map' => 'nullable|string|max:255',
            'game_mode' => 'nullable|string|max:255',
            'icon_color_from' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'icon_color_to' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'display_order' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
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
            'name.required' => 'Server name is required.',
            'game.required' => 'Game is required.',
            'game_short_code.required' => 'Game short code is required.',
            'port.integer' => 'Port must be a valid number.',
            'port.min' => 'Port must be at least 1.',
            'port.max' => 'Port cannot exceed 65535.',
            'icon_color_from.regex' => 'Icon color from must be a valid hex color code (e.g., #FFFFFF).',
            'icon_color_to.regex' => 'Icon color to must be a valid hex color code (e.g., #FFFFFF).',
        ];
    }
}
