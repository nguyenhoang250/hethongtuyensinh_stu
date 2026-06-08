<?php

use Illuminate\Support\Facades\Route;
use Modules\TuVan\Http\Controllers\TuVanController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('tuvans', TuVanController::class)->names('tuvan');
});
