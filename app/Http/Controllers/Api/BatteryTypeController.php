<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BatteryTypeRequest;
use App\Http\Resources\BatteryTypeResource;
use App\Models\BatteryType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class BatteryTypeController extends Controller
{

    public function index(): JsonResponse
    {
        try {
            $types = BatteryType::with('category', 'brand', 'sales')->get();

            if ($types->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No battery type found',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Battery type retrieved successfully',
                'data' => BatteryTypeResource::collection($types)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve battery type',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function store(BatteryTypeRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            // Check if input is array of categories
            if (isset($validated[0])) {
                $types = collect($validated)->map(function ($item) {
                    return BatteryType::create($item);
                });

                return response()->json([
                    'success' => true,
                    'message' => 'Multiple types created successfully',
                    'data' => BatteryTypeResource::collection($types)
                ], 201);
            }

            // Single category creation
            $type = BatteryType::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data type berhasil disimpan',
                'data' => new BatteryTypeResource($type)
            ], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save battery type',
                'error' => 'Database error occurred'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save battery type',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function show($id): JsonResponse
    {
        try {
            $batteryType = BatteryType::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Battery type retrieved successfully',
                'data' => new BatteryTypeResource($batteryType->load('category', 'brand', 'sales'))
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Battery type with ID ' . $id . ' not found'
            ], 404);
        }
    }


    public function update(BatteryTypeRequest $request, $id): JsonResponse
    {
        try {
            $batteryType = BatteryType::findOrFail($id);
            $batteryType->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Battery Type updated successfully',
                'data' => new BatteryTypeResource($batteryType->fresh())
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Battery type with ID ' . $id . ' not found',
            ], 404);
        }
    }


    public function destroy($id): JsonResponse
    {
        try {
            $batteryType = BatteryType::findOrFail($id);
            $batteryType->delete();

            return response()->json([
                'success' => true,
                'message' => 'Battery type deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Battery type with ID ' . $id . ' not found',
            ], 404);
        }
    }
}
