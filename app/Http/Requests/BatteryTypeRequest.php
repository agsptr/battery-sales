<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatteryTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {

        $rules = [
            'type_name' => 'required|string|max:255',
            'category_id' => 'required|exists:battery_categories,category_id',
            'brand_id' => 'required|exists:battery_brands,brand_id'
        ];

        // Get ID from route parameter
        $typeId = $this->route('battery_type');

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['type_id'] = 'required|unique:battery_types,type_id,' . $typeId;
        } else {
            $rules['type_id'] = 'required|unique:battery_types,type_id';
        }

        return $rules;
    }
}
