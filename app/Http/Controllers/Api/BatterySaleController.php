<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BatterySaleResource;
use App\Http\Requests\BatterySaleRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

use App\Models\BatterySale;
use App\Models\BatterySpecification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BatterySaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(): JsonResponse
    {
        try {
            $types = BatterySale::with('category', 'type', 'brand')->get();

            if ($types->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No battery sales found',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Battery sales retrieved successfully',
                'data' => BatterySaleResource::collection($types)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve battery sales',
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

    public function store(BatterySaleRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            // Get cost_price from battery_specifications table
            $specification = BatterySpecification::where([
                'brand_id' => $validated['brand_id'],
                'category_id' => $validated['category_id'],
                'type_id' => $validated['type_id']
            ])->first();

            // Auto-fill cost_price and battery_jenis from specification
            $validated['cost_price'] = $specification->cost_price;
            $validated['battery_jenis'] = $specification->battery_jenis;

            // Calculate profit
            $validated['profit'] = ($validated['selling_price'] - $validated['cost_price']) * $validated['units_sold'];


            // Check if input is array of sales
            if (isset($validated[0])) {
                $sales = collect($validated)->map(function ($item) {
                    return BatterySale::create($item);
                });

                return response()->json([
                    'success' => true,
                    'message' => 'Multiple sales created successfully',
                    'data' => BatterySaleResource::collection($sales)
                ], 201);
            }

            // Single sale creation
            $sale = BatterySale::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data sales berhasil disimpan',
                'data' => new BatterySaleResource($sale->load(['category', 'type', 'brand']))
            ], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save battery sales',
                'error' => 'Database error occurred'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save battery sales',
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
            $batterySale = BatterySale::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Battery sales retrieved successfully',
                'data' => new BatterySaleResource($batterySale->load('category', 'type', 'brand'))
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Battery sales with ID ' . $id . ' not found'
            ], 404);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BatterySale $batterySale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(BatterySaleRequest $request, $id): JsonResponse
    {
        try {
            $batterySale = BatterySale::findOrFail($id);
            $batterySale->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Battery sales updated successfully',
                'data' => new BatterySaleResource($batterySale->fresh())
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Battery sales with ID ' . $id . ' not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(BatterySale $batterySale): JsonResponse
    // {
    //     $batterySale->delete();

    //     return response()->json([
    //         'message' => 'Sale deleted successfully'
    //     ]);
    // }

    public function destroy($id): JsonResponse
    {
        try {
            $batterySale = BatterySale::findOrFail($id);
            $batterySale->delete();

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
