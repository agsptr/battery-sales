<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'type_name',
        'brand_id',
        'category_id',
    ];

    public function sales()
    {
        return $this->hasMany(BatterySale::class, 'type_id', 'type_id');
    }

    public function category()
    {
        return $this->belongsTo(BatteryCategory::class, 'category_id', 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(BatteryBrand::class, 'brand_id', 'brand_id');
    }
}
