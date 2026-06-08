<?php

use Illuminate\Support\Facades\Route;
use Modules\SuKien\Http\Controllers\SuKienController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('sukiens', SuKienController::class)->names('sukien');
});
