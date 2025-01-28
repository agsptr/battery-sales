<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'brand_name',
    ];

    public function types()
    {
        return $this->hasMany(BatteryType::class, 'brand_id', 'brand_id');
    }
}
