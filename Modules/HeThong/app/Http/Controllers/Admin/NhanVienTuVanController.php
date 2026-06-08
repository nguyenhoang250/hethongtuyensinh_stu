<?php

namespace Modules\HeThong\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\HeThong\Models\Admin;
use Modules\HeThong\Models\NhanVienTuVan;

class NhanVienTuVanController extends Controller
{
    public function index()
    {
        $danhSach = NhanVienTuVan::with('admin')->latest()->paginate(20);
        return view('hethong::admin.nhan-vien-tu-van.index', compact('danhSach'));
    }

    public function create()
    {
        return view('hethong::admin.nhan-vien-tu-van.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'ho_ten'        => 'required|string|max:100',
            'email'         => 'required|email|max:150|unique:Admin,email',
            'mat_khau'      => 'required|string|min:8',
            'so_dien_thoai' => 'nullable|string|max:15',
            'ma_nhan_vien'  => 'required|string|max:20|unique:NhanVienTuVan,ma_nhan_vien',
            'phong_ban'     => 'required|string|max:100',
            'chuyen_mon'    => 'nullable|string|max:200',
        ]);

        DB::transaction(function () use ($request) {
            $admin = Admin::create([
                'ho_ten'        => $request->ho_ten,
                'email'         => $request->email,
                'mat_khau'      => Hash::make($request->mat_khau),
                'vai_tro'       => 'nhan_vien_tu_van',
                'so_dien_thoai' => $request->so_dien_thoai,
                'trang_thai'    => 1,
            ]);

            NhanVienTuVan::create([
                'admin_id'     => $admin->id,
                'ma_nhan_vien' => $request->ma_nhan_vien,
                'phong_ban'    => $request->phong_ban,
                'chuyen_mon'   => $request->chuyen_mon,
            ]);
        });

        return redirect()->route('admin.nhan-vien-tu-van.index')
            ->with('success', 'Tạo nhân viên tư vấn thành công!');
    }

    public function edit(NhanVienTuVan $nhanVienTuVan)
    {
        $nhanVienTuVan->load('admin');
        return view('hethong::admin.nhan-vien-tu-van.form', compact('nhanVienTuVan'));
    }

    public function update(Request $request, NhanVienTuVan $nhanVienTuVan): RedirectResponse
    {
        $request->validate([
            'ho_ten'        => 'required|string|max:100',
            'email'         => 'required|email|max:150|unique:Admin,email,' . $nhanVienTuVan->admin_id,
            'so_dien_thoai' => 'nullable|string|max:15',
            'ma_nhan_vien'  => 'required|string|max:20|unique:NhanVienTuVan,ma_nhan_vien,' . $nhanVienTuVan->id,
            'phong_ban'     => 'required|string|max:100',
            'chuyen_mon'    => 'nullable|string|max:200',
            'mat_khau'      => 'nullable|string|min:8',
        ]);

        DB::transaction(function () use ($request, $nhanVienTuVan) {
            $dataAdmin = [
                'ho_ten'        => $request->ho_ten,
                'email'         => $request->email,
                'so_dien_thoai' => $request->so_dien_thoai,
            ];
            if ($request->filled('mat_khau')) {
                $dataAdmin['mat_khau'] = Hash::make($request->mat_khau);
            }
            $nhanVienTuVan->admin->update($dataAdmin);

            $nhanVienTuVan->update([
                'ma_nhan_vien' => $request->ma_nhan_vien,
                'phong_ban'    => $request->phong_ban,
                'chuyen_mon'   => $request->chuyen_mon,
            ]);
        });

        return redirect()->route('admin.nhan-vien-tu-van.index')
            ->with('success', 'Cập nhật nhân viên tư vấn thành công!');
    }

    public function destroy(NhanVienTuVan $nhanVienTuVan): RedirectResponse
    {
        // Xóa admin sẽ cascade xóa NhanVienTuVan (theo FK)
        $nhanVienTuVan->admin->delete();

        return redirect()->route('admin.nhan-vien-tu-van.index')
            ->with('success', 'Xóa nhân viên tư vấn thành công!');
    }
}