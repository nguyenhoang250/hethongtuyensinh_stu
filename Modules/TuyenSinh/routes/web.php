<?php

use Illuminate\Support\Facades\Route;
use Modules\TuyenSinh\Http\Controllers\TuyenSinhController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('tuyensinhs', TuyenSinhController::class)->names('tuyensinh');
});
