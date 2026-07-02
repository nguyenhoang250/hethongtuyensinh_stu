<?php
use Illuminate\Support\Facades\Route;
use Modules\DaoTao\Http\Controllers\KhoaController;
use Modules\DaoTao\Http\Controllers\NganhHocController;
use Modules\DaoTao\Http\Controllers\ToHopMonController;
use Modules\DaoTao\Http\Controllers\HocPhiController;
use Modules\DaoTao\Http\Controllers\ChuongTrinhDaoTaoController;
use Modules\DaoTao\Http\Controllers\Frontend\NganhHocFrontendController;

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Khoa
    Route::resource('khoa', KhoaController::class)->names([
        'index'   => 'khoa.index',
        'create'  => 'khoa.create',
        'store'   => 'khoa.store',
        'show'    => 'khoa.show',
        'edit'    => 'khoa.edit',
        'update'  => 'khoa.update',
        'destroy' => 'khoa.destroy',
    ]);

    // Nganh Hoc
    Route::resource('nganh-hoc', NganhHocController::class)->names([
        'index'   => 'nganh-hoc.index',
        'create'  => 'nganh-hoc.create',
        'store'   => 'nganh-hoc.store',
        'show'    => 'nganh-hoc.show',
        'edit'    => 'nganh-hoc.edit',
        'update'  => 'nganh-hoc.update',
        'destroy' => 'nganh-hoc.destroy',
    ]);

    // ⭐ Tổ hợp môn theo ngành (đặt TRƯỚC resource to-hop-mon)
    Route::get('nganh-hoc/{id}/to-hop-mon', [NganhHocController::class, 'toHopMon'])
        ->name('nganh-hoc.to-hop-mon');
    Route::get('nganh-hoc/{id}/to-hop-mon/them', [ToHopMonController::class, 'createTheoNganh'])
        ->name('nganh-hoc.to-hop-mon.create');
    Route::post('nganh-hoc/{id}/to-hop-mon', [ToHopMonController::class, 'storeTheoNganh'])
        ->name('nganh-hoc.to-hop-mon.store');
    Route::get('nganh-hoc/{nganh_id}/to-hop-mon/{id}/sua', [ToHopMonController::class, 'editTheoNganh'])
        ->name('nganh-hoc.to-hop-mon.edit');
    Route::put('nganh-hoc/{nganh_id}/to-hop-mon/{id}', [ToHopMonController::class, 'updateTheoNganh'])
        ->name('nganh-hoc.to-hop-mon.update');
    Route::delete('nganh-hoc/{nganh_id}/to-hop-mon/{id}', [ToHopMonController::class, 'destroyTheoNganh'])
        ->name('nganh-hoc.to-hop-mon.destroy');

    // To Hop Mon (giữ nguyên cho menu riêng nếu cần)
    Route::resource('to-hop-mon', ToHopMonController::class)->names([
        'index'   => 'to-hop-mon.index',
        'create'  => 'to-hop-mon.create',
        'store'   => 'to-hop-mon.store',
        'show'    => 'to-hop-mon.show',
        'edit'    => 'to-hop-mon.edit',
        'update'  => 'to-hop-mon.update',
        'destroy' => 'to-hop-mon.destroy',
    ]);

    // Hoc Phi
    Route::resource('hoc-phi', HocPhiController::class)->names([
        'index'   => 'hoc-phi.index',
        'create'  => 'hoc-phi.create',
        'store'   => 'hoc-phi.store',
        'show'    => 'hoc-phi.show',
        'edit'    => 'hoc-phi.edit',
        'update'  => 'hoc-phi.update',
        'destroy' => 'hoc-phi.destroy',
    ]);

    // Chuong Trinh Dao Tao
    Route::resource('chuong-trinh-dao-tao', ChuongTrinhDaoTaoController::class)->names([
        'index'   => 'chuong-trinh-dao-tao.index',
        'create'  => 'chuong-trinh-dao-tao.create',
        'store'   => 'chuong-trinh-dao-tao.store',
        'show'    => 'chuong-trinh-dao-tao.show',
        'edit'    => 'chuong-trinh-dao-tao.edit',
        'update'  => 'chuong-trinh-dao-tao.update',
        'destroy' => 'chuong-trinh-dao-tao.destroy',
    ]);

});

// Frontend - thí sinh xem
Route::get('/nganh-hoc', [NganhHocFrontendController::class, 'index'])->name('nganh-hoc.index');
Route::get('/nganh-hoc/{id}', [NganhHocFrontendController::class, 'show'])->name('nganh-hoc.show');