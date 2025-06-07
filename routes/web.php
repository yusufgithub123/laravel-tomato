<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\LoginController;

// Landing Page Route (untuk user yang belum login)
Route::get('/', function () {
    // Jika sudah login, redirect ke home
    if (auth()->check()) {
        return redirect()->route('home');
    }
    // Jika belum login, tampilkan landing page
    return view('landing');
})->name('landing');

// Authentication Routes - HANYA untuk guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register']);
});

// Logout route - hanya untuk user yang sudah login
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Protected Routes - SEMUA HALAMAN UTAMA PERLU LOGIN
Route::middleware(['auth'])->group(function () {
    
    // Halaman utama - semua perlu login
    Route::get('/home', function () {
        return view('pages.home');
    })->name('home');

    // Route klasifikasi - PROTECTED (perlu login)
    Route::get('/klasifikasi', function () {
        return view('pages.classification');
    })->name('classification');

    // Alternative route untuk klasifikasi 
    Route::get('/classification', function () {
        return view('pages.classification');
    })->name('classification.alt');

    // Halaman informasi - semua perlu login
    Route::get('/penyakit', function () {
        return view('pages.diseases');
    })->name('diseases');

    Route::get('/panduan', function () {
        return view('pages.guide');
    })->name('guide');

    Route::get('/tentang', function () {
        return view('pages.about');
    })->name('about');

    Route::get('/kontak', function () {
        return view('pages.contact');
    })->name('contact');

    Route::post('/kontak', [ContactController::class, 'submit'])->name('contact.submit');

    // History routes - sudah protected
    Route::get('/riwayat', [HistoryController::class, 'index'])->name('history');
    Route::get('/history', [HistoryController::class, 'index'])->name('history.alt');
    Route::get('/history/{id}', [HistoryController::class, 'show'])->name('history.show');
    Route::delete('/history/{id}', [HistoryController::class, 'destroy'])->name('history.destroy');
    Route::delete('/history', [HistoryController::class, 'bulkDelete'])->name('history.bulk-delete');

    // Store classification result
    Route::post('/history/store-classification', [HistoryController::class, 'storeClassification'])->name('history.store.classification');
    Route::post('/save-history', [HistoryController::class, 'storeClassification'])->name('history.store');
    Route::post('/save-classification', [HistoryController::class, 'storeClassification'])->name('save.classification');

    // Store from API
    Route::post('/history/store-api', [HistoryController::class, 'storeFromApi'])->name('history.store.api');
    Route::post('/save-from-api', [HistoryController::class, 'storeFromApi'])->name('save.api');

    // Stats API
    Route::get('/api/history/stats', [HistoryController::class, 'getStats'])->name('history.stats');
});

// Fallback route untuk handle 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});