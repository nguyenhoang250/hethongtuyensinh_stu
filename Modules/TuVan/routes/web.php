<?php

use Illuminate\Support\Facades\Route;
use Modules\TuVan\Http\Controllers\TuVanController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('tuvans', TuVanController::class)->names('tuvan');
});
