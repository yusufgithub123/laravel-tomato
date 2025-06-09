<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClassificationController extends Controller
{
    private $pythonApiUrl = 'https://ml-api-production-7867.up.railway.app'; // Gunakan 127.0.0.1 instead of localhost

    public function classify(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Cek apakah API Python tersedia
            $healthCheck = $this->checkPythonApiHealth();
            if (!$healthCheck['available']) {
                return response()->json([
                    'success' => false,
                    'error' => 'AI Model tidak tersedia. ' . $healthCheck['message']
                ], 503);
            }

            // Simpan gambar temporarily
            $imagePath = $request->file('image')->store('classifications', 'public');
            $fullImagePath = storage_path('app/public/' . $imagePath);

            // Kirim request ke Python API dengan error handling yang lebih baik
            $response = Http::timeout(60)
                ->connectTimeout(10)
                ->attach('image', file_get_contents($fullImagePath), $request->file('image')->getClientOriginalName())
                ->post($this->pythonApiUrl . '/predict');

            // Hapus file temporary setelah digunakan
            if (file_exists($fullImagePath)) {
                // Keep the file for now, will be cleaned up later
            }

            if (!$response->successful()) {
                Log::error('Python API Response Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                throw new \Exception('Failed to get prediction from AI model. Status: ' . $response->status());
            }

            $predictionData = $response->json();

            if (!isset($predictionData['success']) || !$predictionData['success']) {
                throw new \Exception('AI prediction failed: ' . ($predictionData['error'] ?? 'Unknown error'));
            }

            $classification = $predictionData['data']['classification'];
            $diseaseInfo = $predictionData['data']['disease_info'];

            // Siapkan data untuk disimpan
            $result = [
                'disease_name' => $diseaseInfo['name'],
                'disease_class' => $classification['class'],
                'accuracy' => $classification['confidence_percentage'],
                'is_healthy' => $classification['is_healthy'],
                'symptoms' => $diseaseInfo['symptoms'],
                'causes' => $diseaseInfo['causes'],
                'prevention' => $diseaseInfo['prevention'],
                'treatment' => $diseaseInfo['treatment'],
                'severity' => $diseaseInfo['severity']
            ];

            // Simpan ke history HANYA jika user login
            $history = null;
            $isUserLoggedIn = Auth::check();
            
            if ($isUserLoggedIn) {
                $history = History::create([
                    'user_id' => Auth::id(),
                    'image_path' => $imagePath,
                    'disease_name' => $result['disease_name'],
                    'disease_class' => $result['disease_class'],
                    'accuracy' => $result['accuracy'],
                    'is_healthy' => $result['is_healthy'],
                    'symptoms' => $result['symptoms'],
                    'causes' => $result['causes'],
                    'prevention' => $result['prevention'],
                    'treatment' => $result['treatment'],
                    'severity' => $result['severity']
                ]);
            }

            // Response yang berbeda untuk user login dan guest
            $responseData = [
                'success' => true,
                'data' => [
                    'classification' => [
                        'class' => $result['disease_class'],
                        'class_name' => $result['disease_name'],
                        'confidence' => $result['accuracy'] / 100,
                        'confidence_percentage' => $result['accuracy'],
                        'is_healthy' => $result['is_healthy'],
                        'severity' => $result['severity']
                    ],
                    'disease_info' => [
                        'name' => $result['disease_name'],
                        'symptoms' => $result['symptoms'],
                        'causes' => $result['causes'],
                        'prevention' => $result['prevention'],
                        'treatment' => $result['treatment'],
                        'severity' => $result['severity']
                    ],
                    'image_url' => Storage::url($imagePath),
                    'user_logged_in' => $isUserLoggedIn
                ]
            ];

            // Tambahkan history ke response hanya jika user login
            if ($isUserLoggedIn && $history) {
                $responseData['data']['history'] = $this->transformHistory($history);
            }

            // Tambahkan pesan untuk guest user
            if (!$isUserLoggedIn) {
                $responseData['data']['guest_message'] = 'Hasil klasifikasi berhasil. Login untuk menyimpan riwayat.';
            }

            return response()->json($responseData);

        } catch (\Exception $e) {
            Log::error('Classification error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Classification failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkApiHealth()
    {
        try {
            $healthStatus = $this->checkPythonApiHealth();
            
            return response()->json([
                'success' => $healthStatus['available'],
                'data' => [
                    'model_loaded' => $healthStatus['model_loaded'] ?? false,
                    'status' => $healthStatus['status'] ?? 'unknown',
                    'message' => $healthStatus['message']
                ]
            ], $healthStatus['available'] ? 200 : 503);

        } catch (\Exception $e) {
            Log::error('API Health Check Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'data' => [
                    'model_loaded' => false,
                    'status' => 'error',
                    'message' => 'API connection failed: ' . $e->getMessage()
                ]
            ], 503);
        }
    }

    private function checkPythonApiHealth()
    {
        try {
            $response = Http::timeout(10)
                ->connectTimeout(5)
                ->get($this->pythonApiUrl . '/health');
            
            if ($response->successful()) {
                $data = $response->json();
                return [
                    'available' => true,
                    'model_loaded' => $data['model_loaded'] ?? false,
                    'status' => $data['status'] ?? 'unknown',
                    'message' => $data['message'] ?? 'API is running'
                ];
            }

            return [
                'available' => false,
                'model_loaded' => false,
                'status' => 'error',
                'message' => 'API returned status: ' . $response->status()
            ];

        } catch (\Exception $e) {
            return [
                'available' => false,
                'model_loaded' => false,
                'status' => 'error',
                'message' => 'Connection failed: ' . $e->getMessage()
            ];
        }
    }

    public function getUserHistory()
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'error' => 'User not authenticated'
                ], 401);
            }

            $histories = History::where('user_id', Auth::id())
                ->latest()
                ->get()
                ->map(fn($history) => $this->transformHistory($history));

            return response()->json([
                'success' => true,
                'data' => $histories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getDiseasesInfo()
    {
        try {
            // Get disease info from Python API
            $response = Http::timeout(10)->get($this->pythonApiUrl . '/diseases');
            
            if ($response->successful()) {
                $apiData = $response->json();
                if ($apiData['success']) {
                    return response()->json([
                        'success' => true,
                        'data' => $apiData['data']
                    ]);
                }
            }

            // Fallback to local data if API fails
            return response()->json([
                'success' => true,
                'data' => $this->getLocalDiseasesInfo()
            ]);

        } catch (\Exception $e) {
            // Fallback to local data
            return response()->json([
                'success' => true,
                'data' => $this->getLocalDiseasesInfo()
            ]);
        }
    }

    private function getLocalDiseasesInfo()
    {
        return [
            [
                'class' => 'Bacterial_spot',
                'info' => [
                    'name' => 'Bacterial Spot',
                    'symptoms' => 'Bercak coklat kecil dengan tepi kuning pada daun, buah, dan batang',
                    'causes' => 'Bakteri Xanthomonas campestris',
                    'prevention' => 'Gunakan benih bebas penyakit, hindari penyiraman dari atas',
                    'treatment' => 'Gunakan bakterisida yang mengandung tembaga',
                    'severity' => 'medium'
                ]
            ],
            [
                'class' => 'Early_blight',
                'info' => [
                    'name' => 'Early Blight',
                    'symptoms' => 'Lesi coklat dengan cincin konsentris pada daun',
                    'causes' => 'Jamur Alternaria solani',
                    'prevention' => 'Jaga drainase yang baik, hindari stress pada tanaman',
                    'treatment' => 'Gunakan fungisida yang mengandung chlorothalonil',
                    'severity' => 'medium'
                ]
            ],
            [
                'class' => 'healthy',
                'info' => [
                    'name' => 'Healthy Plant',
                    'symptoms' => 'Daun hijau segar tanpa bercak',
                    'causes' => 'Tidak ada penyakit',
                    'prevention' => 'Pertahankan kondisi tanam yang optimal',
                    'treatment' => 'Tanaman sehat, lanjutkan perawatan optimal',
                    'severity' => 'none'
                ]
            ]
        ];
    }

    private function transformHistory(History $history)
    {
        return [
            'id' => $history->id,
            'disease_name' => $history->disease_name,
            'disease_class' => $history->disease_class ?? $history->disease_name,
            'accuracy' => (float) $history->accuracy,
            'is_healthy' => (bool) $history->is_healthy,
            'symptoms' => $history->symptoms,
            'causes' => $history->causes,
            'prevention' => $history->prevention,
            'treatment' => $history->treatment,
            'severity' => $history->severity ?? 'unknown',
            'image_url' => Storage::url($history->image_path),
            'created_at' => $history->created_at->toISOString(),
            'updated_at' => $history->updated_at->toISOString()
        ];
    }
}
