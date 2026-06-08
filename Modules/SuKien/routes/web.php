<?php

use Illuminate\Support\Facades\Route;
use Modules\SuKien\Http\Controllers\SuKienController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('sukiens', SuKienController::class)->names('sukien');
});
