<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatterySalesReportRequest extends FormRequest
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
            'time_id' => 'required|string',
            'sale_date' => 'required|date',
            'week' => 'required|integer',
            'month' => 'required|integer',
            'year' => 'required|integer'
        ];
    }
}
