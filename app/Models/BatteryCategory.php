<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'category_name',
    ];

    public function sales()
    {
        return $this->hasMany(BatterySale::class, 'category_id', 'category_id');
    }

    public function types()
    {
        return $this->hasMany(BatteryType::class, 'category_id', 'category_id');
    }
}
