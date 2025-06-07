<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $histories = History::where('user_id', Auth::id())
                ->latest()
                ->get()
                ->map(function ($history) {
                    return $this->transformHistory($history);
                });

            return response()->json([
                'success' => true,
                'data' => $histories,
                'meta' => [
                    'total' => $histories->count()
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|max:2048',
            'disease_name' => 'required|string|max:255',
            'accuracy' => 'required|numeric|between:0,100',
            'is_healthy' => 'required|boolean',
            'solution' => 'nullable|string'
        ]);

        try {
            $imagePath = $request->file('image')->store('history_images', 'public');

            $history = History::create([
                'user_id' => Auth::id(),
                'image_path' => $imagePath,
                'disease_name' => $validated['disease_name'],
                'accuracy' => $validated['accuracy'],
                'is_healthy' => $validated['is_healthy'],
                'solution' => $validated['solution'] ?? null
            ]);

            return response()->json([
                'success' => true,
                'data' => $this->transformHistory($history)
            ], 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $history = History::where('user_id', Auth::id())
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $this->transformHistory($history)
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('History not found', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'disease_name' => 'sometimes|string|max:255',
            'accuracy' => 'sometimes|numeric|between:0,100',
            'is_healthy' => 'sometimes|boolean',
            'solution' => 'nullable|string'
        ]);

        try {
            $history = History::where('user_id', Auth::id())
                ->findOrFail($id);

            $history->update($validated);

            return response()->json([
                'success' => true,
                'data' => $this->transformHistory($history->fresh())
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update history', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $history = History::where('user_id', Auth::id())
                ->findOrFail($id);

            Storage::disk('public')->delete($history->image_path);
            $history->delete();

            return response()->json([
                'success' => true,
                'message' => 'History deleted successfully'
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to delete history', 500);
        }
    }

    /**
     * Get history image
     */
    public function getImage($id)
    {
        try {
            $history = History::where('user_id', Auth::id())
                ->findOrFail($id);

            return Storage::disk('public')->download($history->image_path);
        } catch (\Exception $e) {
            return $this->errorResponse('Image not found', 404);
        }
    }

    /**
     * Get statistics
     */
    public function getStatistics()
    {
        try {
            $stats = [
                'total' => History::where('user_id', Auth::id())->count(),
                'healthy' => History::where('user_id', Auth::id())->where('is_healthy', true)->count(),
                'diseases' => History::where('user_id', Auth::id())
                    ->where('is_healthy', false)
                    ->selectRaw('disease_name, count(*) as count')
                    ->groupBy('disease_name')
                    ->get()
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to get statistics', 500);
        }
    }

    /**
     * Transform history data for API response
     */
    private function transformHistory(History $history)
    {
        return [
            'id' => $history->id,
            'disease_name' => $history->disease_name,
            'accuracy' => (float) $history->accuracy,
            'is_healthy' => (bool) $history->is_healthy,
            'solution' => $history->solution,
            'image_url' => Storage::url($history->image_path),
            'created_at' => $history->created_at->toISOString(),
            'updated_at' => $history->updated_at->toISOString()
        ];
    }

    /**
     * Error response helper
     */
    private function errorResponse($message, $status = 400)
    {
        return response()->json([
            'success' => false,
            'error' => $message
        ], $status);
    }
}