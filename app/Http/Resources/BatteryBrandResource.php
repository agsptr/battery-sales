<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\Http\Resources\BatteryTypeResource;

class BatteryBrandResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'brand_id' => $this->brand_id,
            'brand_name' => $this->brand_name,
            'types' => BatteryTypeResource::collection($this->whenLoaded('types')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
