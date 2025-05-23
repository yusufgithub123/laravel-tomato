<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
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

Route::get('/riwayat', function () {
    return view('pages.history');
})->name('history');

Route::get('/tentang', function () {
    return view('pages.about');
})->name('about');

Route::get('/kontak', function () {
    return view('pages.contact');
})->name('contact');

Route::post('/kontak', [ContactController::class, 'submit'])->name('contact.submit');