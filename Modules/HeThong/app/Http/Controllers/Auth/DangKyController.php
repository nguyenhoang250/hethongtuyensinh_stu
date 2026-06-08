<?php

namespace Modules\HeThong\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\HeThong\Models\ThiSinh;

class DangKyController extends Controller
{
    public function showForm()
    {
        return view('hethong::auth.dang-ky');
    }

    public function dangKy(Request $request): RedirectResponse
    {
        $request->validate([
            'ho_ten'        => 'required|string|max:100',
            'email'         => 'required|email|max:150|unique:thisinh,email',
            'mat_khau'      => 'required|string|min:8|confirmed',
            'so_dien_thoai' => 'required|string|max:15',
            'ngay_sinh'     => 'required|date',
            'gioi_tinh'     => 'required|in:nam,nu,khac',
            'so_cccd'       => 'required|string|size:12|unique:thisinh,so_cccd',
        ], [
            'ho_ten.required'    => 'Vui lòng nhập họ tên.',
            'email.required'     => 'Vui lòng nhập email.',
            'email.unique'       => 'Email này đã được đăng ký.',
            'mat_khau.required'  => 'Vui lòng nhập mật khẩu.',
            'mat_khau.min'       => 'Mật khẩu tối thiểu 8 ký tự.',
            'mat_khau.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'ngay_sinh.required' => 'Vui lòng nhập ngày sinh.',
            'gioi_tinh.required' => 'Vui lòng chọn giới tính.',
            'so_cccd.required'   => 'Vui lòng nhập số CCCD.',
            'so_cccd.size'       => 'Số CCCD phải đúng 12 ký tự.',
            'so_cccd.unique'     => 'Số CCCD này đã được đăng ký.',
        ]);

        ThiSinh::create([
            'ho_ten'            => $request->ho_ten,
            'email'             => $request->email,
            'mat_khau'          => Hash::make($request->mat_khau),
            'so_dien_thoai'     => $request->so_dien_thoai,
            'ngay_sinh'         => $request->ngay_sinh,
            'gioi_tinh'         => $request->gioi_tinh,
            'so_cccd'           => $request->so_cccd,
            'dia_chi'           => null,
            'tinh_thanh'        => null,
            'truong_thpt'       => null,
            'nam_tot_nghiep'    => null,
            'khu_vuc_uu_tien'   => null,
            'doi_tuong_uu_tien' => null,
        ]);

        return redirect()
            ->route('thi-sinh.dang-nhap')
            ->with('status', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
}