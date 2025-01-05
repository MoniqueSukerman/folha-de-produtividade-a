<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DailySheetController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/daily-sheets', [DailySheetController::class, 'store']);
    Route::get('/daily-sheets/{date}', [DailySheetController::class, 'show']);
    Route::put('/daily-sheets/{dailySheet}', [DailySheetController::class, 'update']);
});
