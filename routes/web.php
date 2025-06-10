<?php
// routes/web.php

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Petugas\SurveyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminMapController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard redirect berdasarkan role
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'petugas_lapangan') {
        return redirect()->route('petugas.dashboard');
    }

    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes untuk semua user yang sudah login
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes group
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Analytics
    Route::get('/analytics', [AdminDashboardController::class, 'analytics'])->name('analytics');
    Route::get('/analytics/detailed-stats', [AdminDashboardController::class, 'detailedStats'])->name('analytics.detailed-stats');
    Route::get('/analytics/choropleth-data', [AdminDashboardController::class, 'choroplethData'])->name('analytics.choropleth');
    Route::post('/analytics/filtered-data', [AdminDashboardController::class, 'filteredData'])->name('analytics.filtered');

    // Reports - Dipindahkan ke ReportController
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::post('/reports/export', [ReportController::class, 'exportReport'])->name('reports.export');

    // User management
    Route::resource('users', AdminUserController::class);
    Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
    Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');

    Route::get('/surveys', [AdminDashboardController::class, 'surveys'])->name('surveys.index');
    Route::get('/surveys/{survey}', [AdminDashboardController::class, 'showSurvey'])->name('surveys.show');
    Route::post('/surveys/{survey}/verify', [AdminDashboardController::class, 'verifySurvey'])->name('surveys.verify');
    Route::post('/surveys/{survey}/reject', [AdminDashboardController::class, 'rejectSurvey'])->name('surveys.reject');
    Route::get('/maps', [AdminMapController::class, 'index'])->name('maps');

    // Bulk actions for surveys
    Route::post('/surveys/bulk-verify', [AdminDashboardController::class, 'bulkVerify'])->name('surveys.bulk-verify');
    Route::post('/surveys/bulk-reject', [AdminDashboardController::class, 'bulkReject'])->name('surveys.bulk-reject');
});

// Petugas Lapangan routes - LENGKAP
Route::middleware(['auth', 'verified', 'role:petugas_lapangan'])->prefix('petugas')->name('petugas.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [SurveyController::class, 'dashboard'])->name('dashboard');

    // Resource routes untuk surveys
    Route::resource('surveys', SurveyController::class);

    // API routes untuk dependent dropdown
    Route::get('/api/regencies/{province}', [SurveyController::class, 'getRegencies'])->name('api.regencies');
    Route::get('/api/districts/{regency}', [SurveyController::class, 'getDistricts'])->name('api.districts');
    Route::get('/api/villages/{district}', [SurveyController::class, 'getVillages'])->name('api.villages');

    // Additional survey actions
    Route::post('/surveys/{survey}/submit', [SurveyController::class, 'submitForVerification'])->name('surveys.submit');
    Route::post('/surveys/{survey}/duplicate', [SurveyController::class, 'duplicate'])->name('surveys.duplicate');

    // Map dan statistics
    Route::get('/map', [SurveyController::class, 'map'])->name('map');
    Route::get('/statistics', [SurveyController::class, 'statistics'])->name('statistics'); // ✅ ROUTE YANG HILANG
});

require __DIR__ . '/auth.php';
