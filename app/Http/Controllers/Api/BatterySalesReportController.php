<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BatterySalesReport;
use App\Http\Resources\BatterySalesReportResource;
use App\Http\Requests\BatterySalesReportRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BatterySalesReportController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $reports = BatterySalesReport::with('sales')->get();

            if ($reports->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No sales reports found',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Sales reports retrieved successfully',
                'data' => BatterySalesReportResource::collection($reports)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve sales reports',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(BatterySalesReportRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            if (isset($validated[0])) {
                $reports = collect($validated)->map(function ($item) {
                    return BatterySalesReport::create($item);
                });

                return response()->json([
                    'success' => true,
                    'message' => 'Multiple sales reports created successfully',
                    'data' => BatterySalesReportResource::collection($reports)
                ], 201);
            }

            $report = BatterySalesReport::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Sales report created successfully',
                'data' => new BatterySalesReportResource($report)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create sales report',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $report = BatterySalesReport::with('sales')->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Sales report retrieved successfully',
                'data' => new BatterySalesReportResource($report)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sales report with ID ' . $id . ' not found'
            ], 404);
        }
    }

    public function update(BatterySalesReportRequest $request, $id): JsonResponse
    {
        try {
            $report = BatterySalesReport::findOrFail($id);
            $report->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Sales report updated successfully',
                'data' => new BatterySalesReportResource($report->fresh())
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sales report with ID ' . $id . ' not found'
            ], 404);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $report = BatterySalesReport::findOrFail($id);
            $report->delete();

            return response()->json([
                'success' => true,
                'message' => 'Sales report deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sales report with ID ' . $id . ' not found'
            ], 404);
        }
    }
}
