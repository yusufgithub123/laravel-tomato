<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\LoginController;

// Root route - redirect ke login jika belum auth, ke home jika sudah auth
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('home');
    }
    return redirect()->route('login');
});

// Public Routes (tidak perlu login)
Route::get('/home', function () {
    return view('pages.home');
})->name('home');

Route::get('/klasifikasi', function () {
    return view('pages.classification');
})->name('classification');

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

// Contact form submission
Route::post('/kontak', [ContactController::class, 'submit'])->name('contact.submit');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Protected Routes (perlu login)
Route::middleware(['auth', 'verified'])->group(function () {
    // Riwayat - hanya bisa diakses jika sudah login
    Route::get('/riwayat', [HistoryController::class, 'index'])->name('history');
    Route::delete('/history/{id}', [HistoryController::class, 'destroy'])->name('history.destroy');
    
    // Untuk menyimpan hasil klasifikasi
    Route::post('/save-history', [HistoryController::class, 'store'])->name('history.store');
});

// Fallback route untuk handle 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});