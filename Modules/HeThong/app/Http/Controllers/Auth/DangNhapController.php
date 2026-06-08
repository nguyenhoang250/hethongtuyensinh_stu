<?php

namespace Modules\HeThong\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HeThong\Http\Requests\DangNhapRequest;

class DangNhapController extends Controller
{
    public function showForm()
    {
        if (request()->is('admin/*')) {
            return view('hethong::auth.dang-nhap');
        }
        return view('hethong::auth.thi-sinh.dang-nhap');
    }

   public function dangNhap(DangNhapRequest $request): RedirectResponse
    {
        $credentials = [
            'email'    => $request->email,
            'password' => $request->mat_khau,
        ];

        // Đăng nhập Thí Sinh
        if (request()->is('thi-sinh/*')) {
            if (!Auth::guard('thi_sinh')->attempt($credentials, $request->boolean('nho_toi'))) {
                return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])->onlyInput('email');
            }
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        // Đăng nhập Admin / Nhân viên tư vấn (đều qua guard 'admin')
        if (!Auth::guard('admin')->attempt($credentials, $request->boolean('nho_toi'))) {
            return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])->onlyInput('email');
        }

        $admin = Auth::guard('admin')->user();

        if (!$admin->trang_thai) {
            Auth::guard('admin')->logout();
            return back()->withErrors(['email' => 'Tài khoản đã bị khóa. Vui lòng liên hệ quản trị viên.']);
        }

        $admin->update(['lan_dang_nhap_cuoi' => now()]);
        $request->session()->regenerate();

        // Phân hướng theo vai trò
        if ($admin->laNhanVienTuVan()) {
            return redirect()->route('admin.tu-van.dashboard');
        }

        return redirect()->route('admin.dashboard');
    }

    public function dangXuat(Request $request): RedirectResponse
    {
        if (Auth::guard('thi_sinh')->check()) {
            Auth::guard('thi_sinh')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('thi-sinh.dang-nhap');
        }

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.dang-nhap');
    }
}