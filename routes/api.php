<?php

use App\Http\Controllers\Api\BatteryBrandController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BatterySaleController;
use App\Http\Controllers\Api\BatteryCategoryController;
use App\Http\Controllers\Api\BatterySalesReportController;
use App\Http\Controllers\Api\BatteryTypeController;
use App\Http\Controllers\Api\BatterySpecificationController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::apiResource('/battery-sales', App\Http\Controllers\Api\BatterySaleController::class);

// Route::post('/battery-sales', [BatterySaleController::class, 'store']);

// Route::get('/battery-categories', [BatteryCategoryController::class, 'index']);
// Route::post('/battery-categories', [BatteryCategoryController::class, 'store']);
Route::apiResource('battery-sales', BatterySaleController::class);
Route::apiResource('battery-categories', BatteryCategoryController::class);
Route::apiResource('battery-brands', BatteryBrandController::class);
Route::apiResource('battery-types', BatteryTypeController::class);
Route::apiResource('battery-specs', BatterySpecificationController::class);
Route::apiResource('battery-reports', BatterySalesReportController::class);


// Route::get('/battery-brands', [BatteryBrandController::class, 'index']);
// Route::post('/battery-brands', [BatteryBrandController::class, 'store']);

// Route::get('/battery-types', [BatteryTypeController::class, 'index']);
// Route::post('/battery-types', [BatteryTypeController::class, 'store']);

// Route untuk BatterySale
// Route::prefix('battery-sales')->group(function () {
//     // Mendapatkan semua data penjualan baterai
//     Route::get('/', [BatterySaleController::class, 'index']);

//     // Menyimpan data penjualan baterai baru
//     Route::post('/', [BatterySaleController::class, 'store']);

//     // Mendapatkan detail penjualan baterai berdasarkan ID
//     Route::get('/{batterySale}', [BatterySaleController::class, 'show']);

//     // Memperbarui data penjualan baterai berdasarkan ID
//     Route::put('/{batterySale}', [BatterySaleController::class, 'update']);

//     // Menghapus data penjualan baterai berdasarkan ID
//     Route::delete('/{batterySale}', [BatterySaleController::class, 'destroy']);
// });
