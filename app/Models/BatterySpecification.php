<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BatterySpecification extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'type_id',
        'battery_jenis',
        'cost_price',
        'description'
    ];

    protected $casts = [
        'cost_price' => 'decimal:2'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(BatteryCategory::class, 'category_id', 'category_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(BatteryBrand::class, 'brand_id', 'brand_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(BatteryType::class, 'type_id', 'type_id');
    }
}
