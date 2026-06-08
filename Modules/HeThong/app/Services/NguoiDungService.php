<?php

namespace Modules\HeThong\Services;

use Illuminate\Support\Facades\Hash;
use Modules\HeThong\Models\Admin;
use Modules\HeThong\Models\NhanVienTuVan;
use Illuminate\Support\Facades\DB;

class NguoiDungService
{
    public function taoAdmin(array $data): Admin
    {
        return Admin::create([
            'ho_ten'        => $data['ho_ten'],
            'email'         => $data['email'],
            'mat_khau'      => Hash::make($data['mat_khau']),
            'so_dien_thoai' => $data['so_dien_thoai'] ?? null,
            'anh_dai_dien'  => $data['anh_dai_dien'] ?? null,
            'trang_thai'    => 1,
        ]);
    }

    public function taoNhanVienTuVan(array $data): NhanVienTuVan
    {
        return DB::transaction(function () use ($data) {
            $admin = $this->taoAdmin($data);

            return NhanVienTuVan::create([
                'admin_id'     => $admin->id,
                'ma_nhan_vien' => $data['ma_nhan_vien'],
                'phong_ban'    => $data['phong_ban'],
                'chuyen_mon'   => $data['chuyen_mon'] ?? null,
            ]);
        });
    }

    public function capNhatAdmin(Admin $admin, array $data): Admin
    {
        $payload = [
            'ho_ten'        => $data['ho_ten'],
            'email'         => $data['email'],
            'so_dien_thoai' => $data['so_dien_thoai'] ?? null,
            'anh_dai_dien'  => $data['anh_dai_dien'] ?? null,
        ];

        if (!empty($data['mat_khau'])) {
            $payload['mat_khau'] = Hash::make($data['mat_khau']);
        }

        $admin->update($payload);

        return $admin->fresh();
    }

    public function capNhatNhanVien(NhanVienTuVan $nhanVien, array $data): NhanVienTuVan
    {
        return DB::transaction(function () use ($nhanVien, $data) {
            $this->capNhatAdmin($nhanVien->admin, $data);

            $nhanVien->update([
                'ma_nhan_vien' => $data['ma_nhan_vien'],
                'phong_ban'    => $data['phong_ban'],
                'chuyen_mon'   => $data['chuyen_mon'] ?? null,
            ]);

            return $nhanVien->fresh();
        });
    }

    public function khoaMoTaiKhoan(Admin $admin): bool
    {
        $admin->update(['trang_thai' => !$admin->trang_thai]);
        return $admin->trang_thai;
    }

    public function xoaAdmin(Admin $admin): void
    {
        $admin->delete();
    }
}