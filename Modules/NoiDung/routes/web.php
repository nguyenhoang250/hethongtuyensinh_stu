<?php

use Illuminate\Support\Facades\Route;
use Modules\NoiDung\Http\Controllers\NoiDungController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('noidungs', NoiDungController::class)->names('noidung');
});
