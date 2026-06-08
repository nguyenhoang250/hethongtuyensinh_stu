<?php

use Illuminate\Support\Facades\Route;
use Modules\DaoTao\Http\Controllers\DaoTaoController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('daotaos', DaoTaoController::class)->names('daotao');
});
