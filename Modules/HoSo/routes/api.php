<?php

use Illuminate\Support\Facades\Route;
use Modules\HoSo\Http\Controllers\HoSoController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('hosos', HoSoController::class)->names('hoso');
});
