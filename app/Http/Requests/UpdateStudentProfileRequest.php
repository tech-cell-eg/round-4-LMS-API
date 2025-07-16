<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'headline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'language' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'website' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'youtube' => 'nullable|url',
            'facebook' => 'nullable|url',
        ];
    }
}
