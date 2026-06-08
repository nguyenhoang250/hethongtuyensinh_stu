<?php

namespace Modules\HeThong\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KiemTraVaiTro
{
    public function handle(Request $request, Closure $next, string $vaiTro): Response
    {
        $admin = auth('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.dang-nhap');
        }

        // Kiểm tra tài khoản bị khóa
        if (!$admin->trang_thai) {
            auth('admin')->logout();
            return redirect()->route('admin.dang-nhap')
                ->withErrors(['email' => 'Tài khoản đã bị khóa.']);
        }

        match ($vaiTro) {
            'admin'           => $this->kiemTraAdmin($admin),
            'nhan_vien_tu_van' => $this->kiemTraNhanVien($admin),
            default           => abort(403, 'Vai trò không hợp lệ.')
        };

        return $next($request);
    }

    private function kiemTraAdmin($admin): void
    {
        if (!$admin->laAdmin()) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }
    }

    private function kiemTraNhanVien($admin): void
    {
        if (!$admin->laNhanVienTuVan()) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }
    }
}