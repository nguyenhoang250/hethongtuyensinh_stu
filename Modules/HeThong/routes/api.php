<?php

use Illuminate\Support\Facades\Route;
use Modules\HeThong\Http\Controllers\Auth\DangNhapController;

// API login Admin — trả về Sanctum token
Route::prefix('v1')->group(function () {

    Route::post('admin/dang-nhap', [DangNhapController::class, 'dangNhapApi'])
        ->name('api.admin.dang-nhap');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('admin/dang-xuat', [DangNhapController::class, 'dangXuatApi'])
            ->name('api.admin.dang-xuat');
    });
});