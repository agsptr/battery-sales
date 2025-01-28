<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BatterySpecificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'type_id' => $this->type_id,
            'brand_name' => $this->brand->brand_name,
            'battery_jenis' => $this->battery_jenis,
            'cost_price' => $this->cost_price,
            'description' => $this->description,
            'category' => new BatteryCategoryResource($this->whenLoaded('category')),
            'brand' => new BatteryBrandResource($this->whenLoaded('brand')),
            'type' => new BatteryTypeResource($this->whenLoaded('type')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
