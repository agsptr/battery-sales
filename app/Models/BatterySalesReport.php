<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatterySalesReport extends Model
{/*  */
    use HasFactory;

    protected $fillable = [
        'time_id',
        'sale_date',
        'week',
        'month',
        'year'
    ];

    protected $casts = [
        'sale_date' => 'date',
        'week' => 'integer',
        'month' => 'integer',
        'year' => 'integer'
    ];

    public function sales()
    {
        return $this->hasMany(BatterySale::class, 'sale_date', 'sale_date');
    }
}
