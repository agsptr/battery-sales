<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatterySaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sale_id' => 'required|integer',
            'sale_date' => 'required|date',
            'brand_id' => 'required|exists:battery_brands,brand_id',
            'category_id' => 'required|exists:battery_categories,category_id',
            'type_id' => 'required|exists:battery_types,type_id',
            'units_sold' => 'required|integer|min:1',
            'selling_price' => 'required|numeric|min:0'
        ];
    }
}
