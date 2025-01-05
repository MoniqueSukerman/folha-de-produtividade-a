<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DailySheetController;
use App\Http\Controllers\AuthController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/daily-sheets', [DailySheetController::class, 'index']);
    Route::post('/daily-sheets', [DailySheetController::class, 'store']);
    Route::get('/daily-sheets/{date}', [DailySheetController::class, 'show']);
    Route::put('/daily-sheets/{dailySheet}', [DailySheetController::class, 'update']);
});
