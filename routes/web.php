<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;

// ─────────────────────────────────────────────────────────────────────
// Trang chủ — chỉ thí sinh mới vào được
// ─────────────────────────────────────────────────────────────────────
Route::get('/', [WelcomeController::class, 'index'])->name('home');

// ─────────────────────────────────────────────────────────────────────
// Tự động load route từng module
// ─────────────────────────────────────────────────────────────────────
foreach (glob(base_path('Modules/*/routes/web.php')) as $moduleRoute) {
    require $moduleRoute;
}