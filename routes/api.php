<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClassificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['api'])->group(function () {
    // Classification routes
    Route::post('/classify', [ClassificationController::class, 'classify']);
    Route::get('/health', [ClassificationController::class, 'checkApiHealth']);
    Route::get('/diseases', [ClassificationController::class, 'getDiseasesInfo']);
    
    // Protected routes (require authentication)
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/history', [ClassificationController::class, 'getUserHistory']);
    });
});
Route::middleware(['api'])->prefix('v1')->group(function () {
    
    // Public Authentication routes
    Route::post('/register', [AuthController::class, 'register'])->name('api.register');
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');
    
    // Public classification route
    Route::post('/classifications', [ClassificationController::class, 'classify'])->name('api.classifications');
    
    // Public disease information
    Route::get('/diseases', [ClassificationController::class, 'getDiseasesInfo'])->name('api.diseases');
    
    // Protected routes (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        // Authentication
        Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
        Route::get('/profile', [AuthController::class, 'profile'])->name('api.profile');
        
        // History resources (fully RESTful)
        Route::apiResource('histories', HistoryController::class);
        
        // Additional history endpoints
        Route::get('/histories/{id}/image', [HistoryController::class, 'getImage'])->name('api.histories.image');
        Route::get('/histories/statistics/summary', [HistoryController::class, 'getStatistics'])->name('api.histories.statistics');
        
        // Classification history for authenticated users
        Route::get('/users/me/histories', [ClassificationController::class, 'getUserHistory'])->name('api.user.histories');
    });
});

// Health check endpoint
Route::get('/', function () {
    return response()->json([
        'message' => 'LeafGuard Tomato API',
        'version' => '1.0',
        'status' => 'running'
    ]);
});

