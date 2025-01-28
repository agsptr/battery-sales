<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BatterySalesReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'time_id' => $this->time_id,
            'sale_date' => $this->sale_date,
            'week' => $this->week,
            'month' => $this->month,
            'year' => $this->year,
            'sales' => BatterySaleResource::collection($this->whenLoaded('sales')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
