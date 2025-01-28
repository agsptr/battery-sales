<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BatterySaleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sale_id' => $this->sale_id,
            'sale_date' => $this->sale_date->format('Y-m-d'),
            'battery_jenis' => $this->battery_jenis,
            'brand' => [
                'brand_id' => $this->brand->brand_id,
                'brand_name' => $this->brand->brand_name
            ],
            'category' => [
                'category_id' => $this->category->category_id,
                'category_name' => $this->category->category_name
            ],
            'type' => [
                'type_id' => $this->type->type_id,
                'type_name' => $this->type->type_name
            ],
            'units_sold' => $this->units_sold,
            'cost_price' => number_format($this->cost_price, 2),
            'selling_price' => number_format($this->selling_price, 2),
            'profit' => number_format($this->profit, 2),
            'total_sales' => number_format($this->selling_price * $this->units_sold, 2)
        ];
    }
}
