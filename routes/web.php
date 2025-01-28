<?php

use App\Http\Controllers\Api\BatterySaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/battery-sales', [BatterySaleController::class, 'index']);
// Route::post('/battery-sales', [BatterySaleController::class, 'store']);
// Route::get('/battery-sales/{id}', [BatterySaleController::class, 'show']);
// Route::put('/battery-sales/{id}', [BatterySaleController::class, 'update']);
// Route::delete('/battery-sales/{id}', [BatterySaleController::class, 'destroy']);
