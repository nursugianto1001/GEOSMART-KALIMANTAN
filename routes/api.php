<?php
// routes/api.php

use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\MapController;
use App\Http\Controllers\Api\AnalyticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// User info endpoint
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth');

// Public location API (tidak perlu auth)
Route::prefix('locations')->group(function () {
    Route::get('/provinces', [LocationController::class, 'provinces']);
    Route::get('/provinces/{province}/regencies', [LocationController::class, 'regencies']);
    Route::get('/regencies/{regency}/districts', [LocationController::class, 'districts']);
    Route::get('/districts/{district}/villages', [LocationController::class, 'villages']);
    Route::get('/villages/{village}/neighborhoods', [LocationController::class, 'neighborhoods']);
});

// Protected API routes
Route::middleware('auth')->group(function () {
    // Map data API
    Route::prefix('map')->group(function () {
        Route::get('/poor-families', [MapController::class, 'poorFamilies']);
        Route::get('/public-facilities', [MapController::class, 'publicFacilities']);
        Route::get('/main-roads', [MapController::class, 'mainRoads']);
        Route::get('/choropleth-data', [MapController::class, 'choroplethData']);
        Route::get('/heatmap-data', [MapController::class, 'heatmapData']);
    });
    
    // Analytics API (admin only)
    Route::middleware('role:admin')->prefix('analytics')->group(function () {
        Route::get('/dashboard-stats', [AnalyticsController::class, 'dashboardStats']);
        Route::get('/poverty-trends', [AnalyticsController::class, 'povertyTrends']);
        Route::get('/village-comparison', [AnalyticsController::class, 'villageComparison']);
        Route::post('/custom-report', [AnalyticsController::class, 'customReport']);
    });
    
    // Survey API for mobile app
    Route::prefix('surveys')->group(function () {
        Route::get('/', [SurveyController::class, 'apiIndex']);
        Route::post('/', [SurveyController::class, 'apiStore']);
        Route::get('/{survey}', [SurveyController::class, 'apiShow']);
        Route::put('/{survey}', [SurveyController::class, 'apiUpdate']);
        Route::delete('/{survey}', [SurveyController::class, 'apiDestroy']);
    });
});

// Webhook endpoints (untuk integrasi external)
Route::prefix('webhooks')->group(function () {
    Route::post('/survey-update', [WebhookController::class, 'surveyUpdate']);
    Route::post('/notification', [WebhookController::class, 'notification']);
});
