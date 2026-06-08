<?php

use Illuminate\Support\Facades\Route;
use Modules\HeThong\Http\Controllers\Auth\DangNhapController;
use Modules\HeThong\Http\Controllers\Auth\DangKyController;
use Modules\HeThong\Http\Controllers\Auth\DatLaiMatKhauController;
use Modules\HeThong\Http\Controllers\Admin\AdminController;
use Modules\HeThong\Http\Controllers\Admin\NhanVienTuVanController;
use Modules\HeThong\Http\Controllers\Admin\ThiSinhController;

// ============================================================
// ADMIN & NHÂN VIÊN TƯ VẤN
// ============================================================
Route::prefix('admin')->name('admin.')->group(function () {

    // --- Chưa đăng nhập ---
    Route::middleware('guest:admin')->group(function () {
        Route::get('dang-nhap', [DangNhapController::class, 'showForm'])->name('dang-nhap');
        Route::post('dang-nhap', [DangNhapController::class, 'dangNhap']);

        Route::get('quen-mat-khau', [DatLaiMatKhauController::class, 'showQuenMatKhau'])->name('quen-mat-khau');
        Route::post('quen-mat-khau', [DatLaiMatKhauController::class, 'guiLinkDatLai']);

        Route::get('dat-lai-mat-khau/{token}', [DatLaiMatKhauController::class, 'showDatLai'])->name('dat-lai-mat-khau');
        Route::post('dat-lai-mat-khau', [DatLaiMatKhauController::class, 'datLai']);
    });

    // --- Đăng xuất (cả admin lẫn nvtv đều qua guard 'admin') ---
    Route::post('dang-xuat', [DangNhapController::class, 'dangXuat'])
        ->name('dang-xuat')
        ->middleware('auth:admin');

    // --- Nhân viên tư vấn (vai_tro = nhan_vien_tu_van) ---
    Route::middleware(['auth:admin', 'vai_tro:nhan_vien_tu_van'])->group(function () {
        Route::get('tu-van/dashboard', fn() => view('hethong::admin.tu-van.dashboard'))
            ->name('tu-van.dashboard');
    });

    // --- Quản trị viên (vai_tro = admin) ---
    Route::middleware(['auth:admin', 'vai_tro:admin'])->group(function () {

        Route::get('dashboard', fn() => view('hethong::admin.dashboard'))->name('dashboard');

        // Quản lý tài khoản admin
        Route::prefix('quan-ly')->name('quan-ly.')->group(function () {
            Route::get('/',            [AdminController::class, 'index'])->name('index');
            Route::get('tao',          [AdminController::class, 'create'])->name('create');
            Route::post('tao',         [AdminController::class, 'store'])->name('store');
            Route::get('{admin}/sua',  [AdminController::class, 'edit'])->name('edit');
            Route::put('{admin}',      [AdminController::class, 'update'])->name('update');
            Route::patch('{admin}/khoa', [AdminController::class, 'khoaTaiKhoan'])->name('khoa');
            Route::delete('{admin}',   [AdminController::class, 'destroy'])->name('destroy');
        });

        // Quản lý nhân viên tư vấn
        Route::prefix('nhan-vien-tu-van')->name('nhan-vien-tu-van.')->group(function () {
            Route::get('/',                    [NhanVienTuVanController::class, 'index'])->name('index');
            Route::get('tao',                  [NhanVienTuVanController::class, 'create'])->name('create');
            Route::post('tao',                 [NhanVienTuVanController::class, 'store'])->name('store');
            Route::get('{nhanVienTuVan}/sua',  [NhanVienTuVanController::class, 'edit'])->name('edit');
            Route::put('{nhanVienTuVan}',      [NhanVienTuVanController::class, 'update'])->name('update');
            Route::delete('{nhanVienTuVan}',   [NhanVienTuVanController::class, 'destroy'])->name('destroy');
        });

        // Quản lý thí sinh
        Route::prefix('thi-sinh')->name('thi-sinh.')->group(function () {
            Route::get('/', [ThiSinhController::class, 'index'])->name('index');
        });
    });
});

// ============================================================
// THÍ SINH
// ============================================================
Route::prefix('thi-sinh')->name('thi-sinh.')->group(function () {

    // --- Chưa đăng nhập ---
    Route::middleware('guest:thi_sinh')->group(function () {
        Route::get('dang-ky',   [DangKyController::class, 'showForm'])->name('dang-ky');
        Route::post('dang-ky',  [DangKyController::class, 'dangKy'])->name('dang-ky.store');

        Route::get('dang-nhap',  [DangNhapController::class, 'showForm'])->name('dang-nhap');
        Route::post('dang-nhap', [DangNhapController::class, 'dangNhap']);
    });

    // --- Đã đăng nhập ---
    Route::middleware('auth:thi_sinh')->group(function () {
        Route::post('dang-xuat', [DangNhapController::class, 'dangXuat'])->name('dang-xuat');
        Route::get('dashboard',  fn() => redirect()->route('home'))->name('dashboard');
    });
});