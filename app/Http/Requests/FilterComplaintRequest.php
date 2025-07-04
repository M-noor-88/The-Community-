<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterComplaintRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'nullable|string',
            'category_id' => 'nullable|integer|exists:complaint_categories,id',
            'distance' => 'nullable|integer',
            'region' => 'nullable|string',
            'userComplaints' => 'nullable|boolean'
        ];
    }
}
