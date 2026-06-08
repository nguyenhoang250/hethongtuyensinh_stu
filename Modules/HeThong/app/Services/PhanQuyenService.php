<?php

namespace Modules\HeThong\Services;

use Modules\HeThong\Models\Admin;

class PhanQuyenService
{
    // Check có phải admin thuần không
    public function laAdmin(Admin $admin): bool
    {
        return $admin->laAdmin();
    }

    // Check có phải nhân viên tư vấn không
    public function laNhanVienTuVan(Admin $admin): bool
    {
        return $admin->laNhanVienTuVan();
    }

    // Lấy tên vai trò để hiển thị
    public function tenVaiTro(Admin $admin): string
    {
        return $admin->laNhanVienTuVan()
            ? 'Nhân viên tư vấn'
            : 'Quản trị viên';
    }

    // Lấy route dashboard theo vai trò
    public function dashboardRoute(Admin $admin): string
    {
        return $admin->laNhanVienTuVan()
            ? 'admin.tu-van.dashboard'
            : 'admin.dashboard';
    }
}