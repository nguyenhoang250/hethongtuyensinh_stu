<?php

use Illuminate\Support\Facades\Route;
use Modules\TuyenSinh\Http\Controllers\TuyenSinhController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('tuyensinhs', TuyenSinhController::class)->names('tuyensinh');
});
