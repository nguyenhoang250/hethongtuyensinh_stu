<?php

namespace Modules\HeThong\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\HeThong\Models\Admin;
use Modules\HeThong\Models\NhanVienTuVan;

class AdminController extends Controller
{
    public function index()
    {
        $danhSach = Admin::with('nhanVienTuVan')->latest()->paginate(20);
        return view('hethong::admin.admin.index', compact('danhSach'));
    }

    public function create()
    {
        return view('hethong::admin.admin.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'ho_ten'        => 'required|string|max:100',
            'email'         => 'required|email|max:150|unique:Admin,email',
            'vai_tro'       => 'required|in:admin,nhan_vien_tu_van',
            'mat_khau'      => 'required|string|min:8',
            'so_dien_thoai' => 'nullable|string|max:15',
        ];

        // Nếu là NVTV thì validate thêm
        if ($request->vai_tro === 'nhan_vien_tu_van') {
            $rules['ma_nhan_vien'] = 'required|string|max:20|unique:NhanVienTuVan,ma_nhan_vien';
            $rules['phong_ban']    = 'required|string|max:100';
            $rules['chuyen_mon']   = 'nullable|string|max:200';
        }

        $request->validate($rules, [
            'ho_ten.required'        => 'Vui lòng nhập họ tên.',
            'email.required'         => 'Vui lòng nhập email.',
            'email.unique'           => 'Email đã tồn tại trong hệ thống.',
            'vai_tro.required'       => 'Vui lòng chọn vai trò.',
            'mat_khau.required'      => 'Vui lòng nhập mật khẩu.',
            'mat_khau.min'           => 'Mật khẩu tối thiểu 8 ký tự.',
            'ma_nhan_vien.required'  => 'Vui lòng nhập mã nhân viên.',
            'ma_nhan_vien.unique'    => 'Mã nhân viên đã tồn tại.',
            'phong_ban.required'     => 'Vui lòng nhập phòng ban.',
        ]);

        DB::transaction(function () use ($request) {
            $admin = Admin::create([
                'ho_ten'        => $request->ho_ten,
                'email'         => $request->email,
                'mat_khau'      => Hash::make($request->mat_khau),
                'vai_tro'       => $request->vai_tro,
                'so_dien_thoai' => $request->so_dien_thoai,
                'trang_thai'    => 1,
            ]);

            if ($request->vai_tro === 'nhan_vien_tu_van') {
                NhanVienTuVan::create([
                    'admin_id'     => $admin->id,
                    'ma_nhan_vien' => $request->ma_nhan_vien,
                    'phong_ban'    => $request->phong_ban,
                    'chuyen_mon'   => $request->chuyen_mon,
                ]);
            }
        });

        return redirect()->route('admin.quan-ly.index')
            ->with('success', 'Tạo tài khoản thành công!');
    }

    public function edit(Admin $admin)
    {
        $admin->load('nhanVienTuVan');
        return view('hethong::admin.admin.form', compact('admin'));
    }

    public function update(Request $request, Admin $admin): RedirectResponse
    {
        $rules = [
            'ho_ten'        => 'required|string|max:100',
            'email'         => 'required|email|max:150|unique:Admin,email,' . $admin->id,
            'vai_tro'       => 'required|in:admin,nhan_vien_tu_van',
            'so_dien_thoai' => 'nullable|string|max:15',
            'mat_khau'      => 'nullable|string|min:8',
        ];

        if ($request->vai_tro === 'nhan_vien_tu_van') {
            $nvtvId = $admin->nhanVienTuVan?->id;
            $rules['ma_nhan_vien'] = 'required|string|max:20|unique:NhanVienTuVan,ma_nhan_vien,' . $nvtvId;
            $rules['phong_ban']    = 'required|string|max:100';
            $rules['chuyen_mon']   = 'nullable|string|max:200';
        }

        $request->validate($rules, [
            'ho_ten.required'       => 'Vui lòng nhập họ tên.',
            'email.required'        => 'Vui lòng nhập email.',
            'email.unique'          => 'Email đã tồn tại trong hệ thống.',
            'vai_tro.required'      => 'Vui lòng chọn vai trò.',
            'mat_khau.min'          => 'Mật khẩu tối thiểu 8 ký tự.',
            'ma_nhan_vien.required' => 'Vui lòng nhập mã nhân viên.',
            'ma_nhan_vien.unique'   => 'Mã nhân viên đã tồn tại.',
            'phong_ban.required'    => 'Vui lòng nhập phòng ban.',
        ]);

        DB::transaction(function () use ($request, $admin) {
            $data = [
                'ho_ten'        => $request->ho_ten,
                'email'         => $request->email,
                'vai_tro'       => $request->vai_tro,
                'so_dien_thoai' => $request->so_dien_thoai,
            ];

            if ($request->filled('mat_khau')) {
                $data['mat_khau'] = Hash::make($request->mat_khau);
            }

            $admin->update($data);

            if ($request->vai_tro === 'nhan_vien_tu_van') {
                // Tạo mới hoặc cập nhật NhanVienTuVan
                NhanVienTuVan::updateOrCreate(
                    ['admin_id' => $admin->id],
                    [
                        'ma_nhan_vien' => $request->ma_nhan_vien,
                        'phong_ban'    => $request->phong_ban,
                        'chuyen_mon'   => $request->chuyen_mon,
                    ]
                );
            } else {
                // Nếu đổi từ NVTV sang admin thì xóa record NVTV
                $admin->nhanVienTuVan?->delete();
            }
        });

        return redirect()->route('admin.quan-ly.index')
            ->with('success', 'Cập nhật tài khoản thành công!');
    }

    public function khoaTaiKhoan(Admin $admin): RedirectResponse
    {
        if ($admin->id === auth('admin')->id()) {
            return back()->withErrors(['error' => 'Không thể khóa tài khoản đang đăng nhập.']);
        }

        $admin->update(['trang_thai' => !$admin->trang_thai]);

        $trangThai = $admin->fresh()->trang_thai ? 'mở khóa' : 'khóa';
        return back()->with('success', "Đã {$trangThai} tài khoản thành công!");
    }

    public function destroy(Admin $admin): RedirectResponse
    {
        if ($admin->id === auth('admin')->id()) {
            return back()->withErrors(['error' => 'Không thể xóa tài khoản đang đăng nhập.']);
        }

        $admin->delete();

        return redirect()->route('admin.quan-ly.index')
            ->with('success', 'Xóa tài khoản thành công!');
    }
}