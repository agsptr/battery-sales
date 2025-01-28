<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BatteryTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type_id' => $this->type_id,
            'type_name' => $this->type_name,
            'category' => new BatteryCategoryResource($this->whenLoaded('category')),
            'brand' => new BatteryBrandResource($this->whenLoaded('brand')),
            'sales' => BatterySaleResource::collection($this->whenLoaded('sales')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
