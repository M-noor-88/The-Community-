<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'phone' => 'required|string',
            'age' => 'required|integer',
            'gender' => 'required|in:male,female',
            'bio' => 'nullable|string|max:255',
            'device_token' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'area' => 'nullable|string|max:255',
            'skills' => 'nullable|json',
            'volunteer_fields' => 'nullable|json',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];

    }
}
