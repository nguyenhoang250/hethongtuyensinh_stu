<?php

use Illuminate\Support\Facades\Route;
use Modules\CauHinh\Http\Controllers\CauHinhController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('cauhinhs', CauHinhController::class)->names('cauhinh');
});
