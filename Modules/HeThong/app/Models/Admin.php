<?php

namespace Modules\HeThong\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'Admin';

    protected $fillable = [
        'ho_ten',
        'email',
        'mat_khau',
        'vai_tro',
        'so_dien_thoai',
        'anh_dai_dien',
        'trang_thai',
        'lan_dang_nhap_cuoi',
    ];

    protected $hidden = [
        'mat_khau',
        'remember_token',
    ];

    protected $casts = [
        'trang_thai'         => 'boolean',
        'lan_dang_nhap_cuoi' => 'datetime',
    ];

    public function getAuthPasswordName(): string
    {
        return 'mat_khau';
    }

    public function laAdmin(): bool
    {
        return $this->vai_tro === 'admin';
    }

    public function laNhanVienTuVan(): bool
    {
        return $this->vai_tro === 'nhan_vien_tu_van';
    }

    public function nhanVienTuVan()
    {
        return $this->hasOne(NhanVienTuVan::class, 'admin_id');
    }
}