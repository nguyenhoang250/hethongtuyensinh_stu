<?php

use Illuminate\Support\Facades\Route;
use Modules\CauHinh\Http\Controllers\CauHinhController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('cauhinhs', CauHinhController::class)->names('cauhinh');
});
