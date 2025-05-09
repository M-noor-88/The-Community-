<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $image
 */
class ComplaintRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'area' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string', // ✅ FIXED
            'complaint_category_id' => 'required|exists:complaint_categories,id' // ✅ SPECIFIED COLUMN
        ];
    }
}
