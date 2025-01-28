<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatteryCategoryRequest extends FormRequest
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
        $rules = [
            '*.category_name' => 'required|string|max:255',
        ];

        // Get ID from route parameter
        $categoryId = $this->route('battery_category');

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['*.category_id'] = 'required|unique:battery_categories,category_id,' . $categoryId;
        } else {
            $rules['*.category_id'] = 'required|unique:battery_categories,category_id';
        }

        return $rules;
    }
}
