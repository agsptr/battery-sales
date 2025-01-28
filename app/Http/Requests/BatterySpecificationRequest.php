<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatterySpecificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:battery_categories,category_id',
            'brand_id' => 'required|exists:battery_brands,brand_id',
            'type_id' => 'required|exists:battery_types,type_id',
            'battery_jenis' => 'required|string|max:255',
            'cost_price' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ];
    }
}
