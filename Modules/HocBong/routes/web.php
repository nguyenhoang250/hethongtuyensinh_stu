<?php

use Illuminate\Support\Facades\Route;
use Modules\HocBong\Http\Controllers\HocBongController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('hocbongs', HocBongController::class)->names('hocbong');
});
