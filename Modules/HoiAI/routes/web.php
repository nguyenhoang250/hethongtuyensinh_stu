<?php

use Illuminate\Support\Facades\Route;
use Modules\HoiAI\Http\Controllers\HoiAIController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('hoiais', HoiAIController::class)->names('hoiai');
});
