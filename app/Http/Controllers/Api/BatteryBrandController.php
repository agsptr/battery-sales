<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BatteryBrandRequest;
use App\Http\Resources\BatteryBrandResource;
use App\Models\BatteryBrand;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class BatteryBrandController extends Controller
{
    public function index(): JsonResponse
    {

        try {
            $brands = BatteryBrand::with('types')->get();

            if ($brands->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No battery brands found',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Battery brands retrieved successfully',
                'data' => BatteryBrandResource::collection($brands)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve battery brands',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(BatteryBrandRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            // Check if input is array of brands
            if (isset($validated[0])) {
                $brands = collect($validated)->map(function ($item) {
                    return BatteryBrand::create($item);
                });

                return response()->json([
                    'success' => true,
                    'message' => 'Multiple brands created successfully',
                    'data' => BatteryBrandResource::collection($brands)
                ], 201);
            }

            // Single category creation
            $brand = BatteryBrand::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data brand berhasil disimpan',
                'data' => new BatteryBrandResource($brand)
            ], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save battery brand',
                'error' => 'Database error occurred'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save battery Brand',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $batteryBrand = BatteryBrand::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Battery brand retrieved successfully',
                'data' => new BatteryBrandResource($batteryBrand->load('types'))
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Battery brand with ID ' . $id . ' not found'
            ], 404);
        }
    }

    public function update(BatteryBrandRequest $request, $id): JsonResponse
    {
        try {
            $batteryBrand = BatteryBrand::findOrFail($id);
            $batteryBrand->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Battery brand updated successfully',
                'data' => new BatteryBrandResource($batteryBrand->fresh())
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Battery brand with ID ' . $id . ' not found',
            ], 404);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $batteryBrand = BatteryBrand::findOrFail($id);
            $batteryBrand->delete();

            return response()->json([
                'success' => true,
                'message' => 'Battery brand deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Battery brand with ID ' . $id . ' not found',
            ], 404);
        }
    }
}
