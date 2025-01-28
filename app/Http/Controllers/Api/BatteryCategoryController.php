<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BatteryCategory;
use App\Http\Resources\BatteryCategoryResource;
use App\Http\Requests\BatteryCategoryRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class BatteryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(): JsonResponse
    {
        try {
            $categories = BatteryCategory::with('types')->get();

            if ($categories->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No battery categories found',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Battery categories retrieved successfully',
                'data' => BatteryCategoryResource::collection($categories)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve battery categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(BatteryCategoryRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            // Check if input is array of categories
            if (isset($validated[0])) {
                $categories = collect($validated)->map(function ($item) {
                    return BatteryCategory::create($item);
                });

                return response()->json([
                    'success' => true,
                    'message' => 'Multiple categories created successfully',
                    'data' => BatteryCategoryResource::collection($categories)
                ], 201);
            }

            // Single category creation
            $category = BatteryCategory::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data kategori berhasil disimpan',
                'data' => new BatteryCategoryResource($category)
            ], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save battery category',
                'error' => 'Database error occurred'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save battery category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */

    public function show($id): JsonResponse
    {
        try {
            $batteryCategory = BatteryCategory::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Battery category retrieved successfully',
                'data' => new BatteryCategoryResource($batteryCategory->load('types'))
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Battery category with ID ' . $id . ' not found'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BatteryCategory $batteryCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(BatteryCategoryRequest $request, $id): JsonResponse
    {
        try {
            $batteryCategory = BatteryCategory::findOrFail($id);
            $batteryCategory->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Battery category updated successfully',
                'data' => new BatteryCategoryResource($batteryCategory->fresh())
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Battery category with ID ' . $id . ' not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id): JsonResponse
    {
        try {
            $batteryCategory = BatteryCategory::findOrFail($id);
            $batteryCategory->delete();

            return response()->json([
                'success' => true,
                'message' => 'Battery category deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Battery category with ID ' . $id . ' not found',
            ], 404);
        }
    }
}
