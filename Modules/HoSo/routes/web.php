<?php

use Illuminate\Support\Facades\Route;
use Modules\HoSo\Http\Controllers\HoSoController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('hosos', HoSoController::class)->names('hoso');
});
