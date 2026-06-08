<?php

use Illuminate\Support\Facades\Route;
use Modules\DaoTao\Http\Controllers\DaoTaoController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('daotaos', DaoTaoController::class)->names('daotao');
});
