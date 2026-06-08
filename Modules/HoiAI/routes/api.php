<?php

use Illuminate\Support\Facades\Route;
use Modules\HoiAI\Http\Controllers\HoiAIController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('hoiais', HoiAIController::class)->names('hoiai');
});
