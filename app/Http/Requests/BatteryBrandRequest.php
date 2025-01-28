<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatteryBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array

    {
        $rules = [
            '*.brand_name' => 'required|string|max:255',
        ];

        // Get ID from route parameter
        $brandId = $this->route('battery_brand');

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['*.brand_id'] = 'required|unique:battery_brands,brand_id,' . $brandId;
        } else {
            $rules['*.brand_id'] = 'required|unique:battery_brands,brand_id';
        }

        return $rules;
    }
}
