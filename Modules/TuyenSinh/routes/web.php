<?php

use Illuminate\Support\Facades\Route;
use Modules\TuyenSinh\Http\Controllers\PhuongThucXTController;
use Modules\TuyenSinh\Http\Controllers\DotTuyenSinhController;
use Modules\TuyenSinh\Http\Controllers\ChiTieuController;
use Modules\TuyenSinh\Http\Controllers\Frontend\TuyenSinhFrontendController;

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Phuong Thuc Xet Tuyen
    Route::resource('phuong-thuc-xt', PhuongThucXTController::class)->names([
        'index'   => 'phuong-thuc-xt.index',
        'create'  => 'phuong-thuc-xt.create',
        'store'   => 'phuong-thuc-xt.store',
        'show'    => 'phuong-thuc-xt.show',
        'edit'    => 'phuong-thuc-xt.edit',
        'update'  => 'phuong-thuc-xt.update',
        'destroy' => 'phuong-thuc-xt.destroy',
    ]);

    // Dot Tuyen Sinh
    Route::resource('dot-tuyen-sinh', DotTuyenSinhController::class)->names([
        'index'   => 'dot-tuyen-sinh.index',
        'create'  => 'dot-tuyen-sinh.create',
        'store'   => 'dot-tuyen-sinh.store',
        'show'    => 'dot-tuyen-sinh.show',
        'edit'    => 'dot-tuyen-sinh.edit',
        'update'  => 'dot-tuyen-sinh.update',
        'destroy' => 'dot-tuyen-sinh.destroy',
    ]);

    // Chi Tieu
    Route::resource('chi-tieu', ChiTieuController::class)->names([
        'index'   => 'chi-tieu.index',
        'create'  => 'chi-tieu.create',
        'store'   => 'chi-tieu.store',
        'show'    => 'chi-tieu.show',
        'edit'    => 'chi-tieu.edit',
        'update'  => 'chi-tieu.update',
        'destroy' => 'chi-tieu.destroy',
    ]);

});

// Frontend - thí sinh xem
Route::get('/tuyen-sinh', [TuyenSinhFrontendController::class, 'index'])->name('tuyen-sinh.index');
Route::get('/tuyen-sinh/{id}', [TuyenSinhFrontendController::class, 'show'])->name('tuyen-sinh.show');