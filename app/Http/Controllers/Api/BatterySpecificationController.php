<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BatterySpecification;
use App\Http\Resources\BatterySpecificationResource;
use App\Http\Requests\BatterySpecificationRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class BatterySpecificationController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $specifications = BatterySpecification::with('category')->get();

            if ($specifications->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No battery specifications found',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Battery specifications retrieved successfully',
                'data' => BatterySpecificationResource::collection($specifications)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve battery specifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(BatterySpecificationRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $specification = BatterySpecification::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Battery specification created successfully',
                'data' => new BatterySpecificationResource($specification)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create battery specification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $specification = BatterySpecification::with('category')->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Battery specification retrieved successfully',
                'data' => new BatterySpecificationResource($specification)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Battery specification with ID ' . $id . ' not found'
            ], 404);
        }
    }

    public function update(BatterySpecificationRequest $request, $id): JsonResponse
    {
        try {
            $specification = BatterySpecification::findOrFail($id);
            $specification->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Battery specification updated successfully',
                'data' => new BatterySpecificationResource($specification->fresh())
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Battery specification with ID ' . $id . ' not found'
            ], 404);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $specification = BatterySpecification::findOrFail($id);
            $specification->delete();

            return response()->json([
                'success' => true,
                'message' => 'Battery specification deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Battery specification with ID ' . $id . ' not found'
            ], 404);
        }
    }
}
