<?php

namespace Modules\HeThong\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NhatKyService
{
    public function ghiLog(string $hanhDong, string $doiTuong, int $doiTuongId, array $chiTiet = []): void
    {
        $admin = Auth::guard('admin')->user();

        Log::channel('daily')->info('AUDIT', [
            'hanh_dong'    => $hanhDong,
            'doi_tuong'    => $doiTuong,
            'doi_tuong_id' => $doiTuongId,
            'admin_id'     => $admin?->id,
            'admin_email'  => $admin?->email,
            'chi_tiet'     => $chiTiet,
            'ip'           => request()->ip(),
            'thoi_gian'    => now()->toDateTimeString(),
        ]);
    }

    public function ghiDangNhap(int $adminId, string $email): void
    {
        $this->ghiLog('DANG_NHAP', 'Admin', $adminId, [
            'email' => $email,
            'ip'    => request()->ip(),
        ]);
    }

    public function ghiDangXuat(int $adminId, string $email): void
    {
        $this->ghiLog('DANG_XUAT', 'Admin', $adminId, [
            'email' => $email,
        ]);
    }
}