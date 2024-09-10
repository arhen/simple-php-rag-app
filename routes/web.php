<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ChatController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\GoogleController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

// User routes
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/upload', function () {
        return Inertia::render('Upload');
    })->name('upload.index');
    Route::post('/upload', [DocumentController::class, 'upload'])->name('upload.store');

    Route::get('/chat', function () {
        return Inertia::render('Chat');
    })->name('chat.index');

    Route::post('/chat', [ChatController::class, 'chat'])->name('chat');
});

require __DIR__.'/auth.php';

Route::fallback(function () {
    return Inertia::render('NotFound');
})->name('not-found');

// Google authentication routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::post('auth/google', [GoogleController::class, 'handleGoogleLogin'])->name('auth.google');
