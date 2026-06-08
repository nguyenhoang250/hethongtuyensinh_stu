<?php

use Illuminate\Support\Facades\Route;
use Modules\HocBong\Http\Controllers\HocBongController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('hocbongs', HocBongController::class)->names('hocbong');
});
