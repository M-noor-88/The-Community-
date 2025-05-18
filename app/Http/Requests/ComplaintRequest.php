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
            'complaintImages' => 'nullable|array',
            'complaintImages.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:5120', // 5MB max
            'title' => 'required|string|max:255',
            'description' => 'required|string', // ✅ FIXED
            'complaint_category_id' => 'required|exists:complaint_categories,id', // ✅ SPECIFIED COLUMN
        ];
    }
}
