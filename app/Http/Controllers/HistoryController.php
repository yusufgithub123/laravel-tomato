<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
      public function index()
    {
        $histories = collect();
        
        if (Auth::check()) {
            $histories = History::where('user_id', Auth::id())
                ->latest()
                ->paginate(10);
                
            // Add computed attributes for display
            $histories->getCollection()->transform(function ($history) {
                $history->severity_color = $this->getSeverityColor($history->severity);
                $history->severity_text = $this->getSeverityText($history->severity);
                return $history;
            });
            
            Log::info('Loaded histories for user', ['user_id' => Auth::id(), 'count' => $histories->count()]);
        }
        
        return view('pages.history', compact('histories'));
    }

    public function bulkDelete(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak terautentikasi'
                ], 401);
            }

            $validated = $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'integer|exists:histories,id'
            ]);

            $deletedCount = 0;
            $histories = History::whereIn('id', $validated['ids'])
                ->where('user_id', Auth::id())
                ->get();

            foreach ($histories as $history) {
                // Delete image file if exists
                if ($history->image_path && Storage::disk('public')->exists($history->image_path)) {
                    Storage::disk('public')->delete($history->image_path);
                }
                
                $history->delete();
                $deletedCount++;
            }

            Log::info('Bulk delete completed', [
                'user_id' => Auth::id(),
                'deleted_count' => $deletedCount
            ]);

            return response()->json([
                'success' => true,
                'message' => "Berhasil menghapus {$deletedCount} riwayat"
            ]);

        } catch (\Exception $e) {
            Log::error('Error in bulk delete', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus riwayat'
            ], 500);
        }
    }

    /**
     * Store classification result from frontend - MAIN METHOD
     */
    public function storeClassification(Request $request)
    {
        try {
            Log::info('Classification save request received', [
                'user_id' => Auth::id(),
                'has_image' => $request->hasFile('image'),
                'request_data' => $request->except(['image'])
            ]);

            // Check authentication
            if (!Auth::check()) {
                Log::warning('Unauthenticated request to store classification');
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Validate input data with more flexible rules
            $validated = $request->validate([
                'image' => 'required|file|mimes:jpeg,png,jpg,gif,webp|max:16384', // 16MB max
                'disease_name' => 'required|string|max:255',
                'disease_class' => 'nullable|string|max:100',
                'accuracy' => 'required|numeric|between:0,100',
                'is_healthy' => 'required|boolean',
                'symptoms' => 'nullable|string|max:1000',
                'causes' => 'nullable|string|max:1000',
                'prevention' => 'nullable|string|max:1000',
                'treatment' => 'nullable|string|max:1000',
                'severity' => 'nullable|string|max:50',
            ]);

            Log::info('Validation passed', ['validated_data' => $validated]);

            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    $imageName = 'history_' . time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
                    $imagePath = $image->storeAs('history', $imageName, 'public');
                    Log::info('Image uploaded successfully', ['path' => $imagePath]);
                } catch (\Exception $e) {
                    Log::error('Image upload failed', ['error' => $e->getMessage()]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to upload image: ' . $e->getMessage()
                    ], 500);
                }
            }

            // Create history record
            $historyData = [
                'user_id' => Auth::id(),
                'image_path' => $imagePath,
                'disease_name' => $validated['disease_name'],
                'disease_class' => $validated['disease_class'] ?? null,
                'accuracy' => $validated['accuracy'],
                'is_healthy' => $validated['is_healthy'],
                'symptoms' => $validated['symptoms'] ?? null,
                'causes' => $validated['causes'] ?? null,
                'prevention' => $validated['prevention'] ?? null,
                'treatment' => $validated['treatment'] ?? null,
                'severity' => $validated['severity'] ?? null,
                'solution' => $this->generateSolution($validated)
            ];

            Log::info('Creating history record', ['data' => $historyData]);

            $history = History::create($historyData);

            Log::info('Classification saved to history successfully', [
                'history_id' => $history->id, 
                'user_id' => Auth::id(),
                'disease_name' => $history->disease_name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Classification result saved successfully',
                'data' => [
                    'id' => $history->id,
                    'disease_name' => $history->disease_name,
                    'accuracy' => $history->accuracy,
                    'is_healthy' => $history->is_healthy,
                    'created_at' => $history->created_at->format('Y-m-d H:i:s')
                ],
                'redirect_url' => route('history')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in storeClassification', [
                'errors' => $e->errors(),
                'user_id' => Auth::id()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error in storeClassification', [
                'error' => $e->getMessage(), 
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'request_data' => $request->except(['image'])
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to save classification result: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store from API data (when image is already base64 or processed)
     */
    public function storeFromApi(Request $request)
    {
        try {
            Log::info('API store request received', ['user_id' => Auth::id()]);

            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $validated = $request->validate([
                'image_base64' => 'required|string',
                'disease_name' => 'required|string|max:255',
                'disease_class' => 'nullable|string|max:100',
                'accuracy' => 'required|numeric|between:0,100',
                'is_healthy' => 'required|boolean',
                'symptoms' => 'nullable|string|max:1000',
                'causes' => 'nullable|string|max:1000',
                'prevention' => 'nullable|string|max:1000',
                'treatment' => 'nullable|string|max:1000',
                'severity' => 'nullable|string|max:50',
            ]);

            // Save base64 image to storage
            $imagePath = $this->saveBase64Image($validated['image_base64']);
            
            if (!$imagePath) {
                throw new \Exception("Failed to save image");
            }

            $history = History::create([
                'user_id' => Auth::id(),
                'image_path' => $imagePath,
                'disease_name' => $validated['disease_name'],
                'disease_class' => $validated['disease_class'] ?? null,
                'accuracy' => $validated['accuracy'],
                'is_healthy' => $validated['is_healthy'],
                'symptoms' => $validated['symptoms'] ?? null,
                'causes' => $validated['causes'] ?? null,
                'prevention' => $validated['prevention'] ?? null,
                'treatment' => $validated['treatment'] ?? null,
                'severity' => $validated['severity'] ?? null,
                'solution' => $this->generateSolution($validated)
            ]);

            Log::info('API classification saved successfully', ['history_id' => $history->id]);

            return response()->json([
                'success' => true,
                'message' => 'Classification saved successfully',
                'data' => $history
            ]);

        } catch (\Exception $e) {
            Log::error('Error in storeFromApi', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to save classification: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $history = History::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $history->severity_color = $this->getSeverityColor($history->severity);
        $history->severity_text = $this->getSeverityText($history->severity);
        
        return view('pages.history-detail', compact('history'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Pastikan user terautentikasi
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak terautentikasi'
                ], 401);
            }

            // Cari history berdasarkan ID dan user
            $history = History::where('id', $id)
                ->where('user_id', Auth::id())
                ->first();
            
            if (!$history) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data riwayat tidak ditemukan'
                ], 404);
            }
            
            // Delete image file if exists
            if ($history->image_path && Storage::disk('public')->exists($history->image_path)) {
                Storage::disk('public')->delete($history->image_path);
                Log::info('Image deleted successfully', ['path' => $history->image_path]);
            }
            
            // Delete the history record
            $history->delete();
            
            Log::info('History deleted successfully', [
                'history_id' => $id, 
                'user_id' => Auth::id(),
                'disease_name' => $history->disease_name
            ]);
            
            // Return appropriate response based on request type
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Riwayat berhasil dihapus'
                ]);
            } else {
                // For traditional form submission
                return redirect()->route('history')->with('success', 'Riwayat berhasil dihapus');
            }
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('History not found for deletion', [
                'history_id' => $id, 
                'user_id' => Auth::id()
            ]);
            
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data riwayat tidak ditemukan'
                ], 404);
            } else {
                return redirect()->route('history')->with('error', 'Data riwayat tidak ditemukan');
            }
            
        } catch (\Exception $e) {
            Log::error('Error deleting history', [
                'error' => $e->getMessage(), 
                'history_id' => $id,
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus riwayat: ' . $e->getMessage()
                ], 500);
            } else {
                return redirect()->route('history')->with('error', 'Gagal menghapus riwayat');
            }
        }
    }

    /**
     * Generate solution text based on classification data
     */
    private function generateSolution($data)
    {
        if ($data['is_healthy']) {
            return 'Daun tomat dalam kondisi sehat. Lanjutkan perawatan rutin untuk menjaga kesehatan tanaman.';
        }
        
        $solution = 'Berdasarkan hasil klasifikasi, ditemukan penyakit: ' . $data['disease_name'] . '. ';
        
        if (!empty($data['treatment'])) {
            $solution .= 'Pengobatan yang disarankan: ' . $data['treatment'] . '. ';
        }
        
        if (!empty($data['prevention'])) {
            $solution .= 'Pencegahan: ' . $data['prevention'] . '.';
        }
        
        return $solution;
    }

    /**
     * Save base64 image to storage
     */
    private function saveBase64Image($base64String)
    {
        try {
            // Remove data URL prefix if present
            if (strpos($base64String, 'data:image/') === 0) {
                $base64String = substr($base64String, strpos($base64String, ',') + 1);
            }
            
            // Decode base64
            $imageData = base64_decode($base64String);
            
            if ($imageData === false) {
                return false;
            }
            
            // Generate filename
            $fileName = 'history_' . time() . '_' . Str::random(8) . '.jpg';
            $filePath = 'history/' . $fileName;
            
            // Save to storage
            if (Storage::disk('public')->put($filePath, $imageData)) {
                return $filePath;
            }
            
            return false;
            
        } catch (\Exception $e) {
            Log::error('Error saving base64 image', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Get severity color for display
     */
    private function getSeverityColor($severity)
    {
        if (!$severity) return '#28a745'; // green for healthy/none
        
        $severityLower = strtolower($severity);
        switch ($severityLower) {
            case 'tinggi':
            case 'high':
                return '#dc3545'; // red
            case 'sedang':
            case 'medium':
                return '#fd7e14'; // orange
            case 'rendah':
            case 'low':
                return '#ffc107'; // yellow
            case 'tidak ada':
            case 'none':
                return '#28a745'; // green
            default:
                return '#6c757d'; // gray
        }
    }

    /**
     * Get formatted severity text
     */
    private function getSeverityText($severity)
    {
        if (!$severity) return 'Tidak Ada';
        
        $severityMap = [
            'tinggi' => 'Tinggi',
            'sedang' => 'Sedang',
            'rendah' => 'Rendah',
            'tidak ada' => 'Tidak Ada',
            'high' => 'Tinggi',
            'medium' => 'Sedang',
            'low' => 'Rendah',
            'none' => 'Tidak Ada'
        ];
        
        return $severityMap[strtolower($severity)] ?? ucfirst($severity);
    }

    /**
     * Get statistics for dashboard
     */
    public function getStats()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $userId = Auth::id();
        
        $stats = [
            'total_classifications' => History::where('user_id', $userId)->count(),
            'healthy_count' => History::where('user_id', $userId)->where('is_healthy', true)->count(),
            'disease_count' => History::where('user_id', $userId)->where('is_healthy', false)->count(),
            'recent_classifications' => History::where('user_id', $userId)
                ->latest()
                ->limit(5)
                ->get(['disease_name', 'accuracy', 'is_healthy', 'created_at']),
            'disease_distribution' => History::where('user_id', $userId)
                ->where('is_healthy', false)
                ->selectRaw('disease_name, COUNT(*) as count')
                ->groupBy('disease_name')
                ->orderByDesc('count')
                ->limit(10)
                ->get()
        ];
        
        return response()->json($stats);
    }
}