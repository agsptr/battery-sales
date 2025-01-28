<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatterySale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'sale_date',
        'brand_id',
        'battery_jenis',
        'category_id',
        'type_id',
        'units_sold',
        'cost_price',
        'selling_price',
        'profit'
    ];

    protected $casts = [
        'sale_date' => 'date',
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'profit' => 'decimal:2'
    ];

    public function category()
    {
        return $this->belongsTo(BatteryCategory::class, 'category_id', 'category_id');
    }

    public function type()
    {
        return $this->belongsTo(BatteryType::class, 'type_id', 'type_id');
    }

    public function salesReport()
    {
        return $this->belongsTo(BatterySalesReport::class, 'sale_date', 'sale_date');
    }

    public function brand()
    {
        return $this->belongsTo(BatteryBrand::class, 'brand_id', 'brand_id');
    }
}
