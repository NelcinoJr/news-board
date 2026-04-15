<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NewsController;

// Portal (Globo.com style)
Route::get('/', function () {
    return view('portal');
});

// Admin Panel
Route::get('/admin', function () {
    return view('admin');
});

// API Routes
Route::get('/api/categories', [CategoryController::class, 'index']);
Route::post('/api/categories', [CategoryController::class, 'store']);

Route::get('/api/news', [NewsController::class, 'index']);
Route::post('/api/news', [NewsController::class, 'store']);
Route::delete('/api/news/{id}', [NewsController::class, 'destroy']);
