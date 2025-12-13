<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTournamentRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'game' => 'nullable|string|max:255',
            'format' => 'required|in:single_elimination,double_elimination,round_robin,swiss',
            'type' => 'required|in:solo,team',
            'team_size' => 'nullable|integer|min:2|max:32',
            'max_participants' => 'required|integer|min:2|max:512',
            'prize_pool' => 'nullable|numeric|min:0',
            'registration_opens_at' => 'nullable|date',
            'registration_closes_at' => 'nullable|date|after:registration_opens_at',
            'check_in_starts_at' => 'nullable|date',
            'check_in_ends_at' => 'nullable|date|after:check_in_starts_at',
            'starts_at' => 'required|date|after:now',
            'rules' => 'nullable|array',
            'is_public' => 'boolean',
            'requires_approval' => 'boolean',
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
            'name.required' => 'Tournament name is required.',
            'format.required' => 'Please select a tournament format.',
            'format.in' => 'Invalid tournament format selected.',
            'type.required' => 'Please select tournament type (solo or team).',
            'max_participants.required' => 'Maximum participants is required.',
            'starts_at.after' => 'Tournament must start in the future.',
        ];
    }
}
