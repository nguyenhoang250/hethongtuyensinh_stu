<?php

namespace Modules\HeThong\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ThiSinh extends Authenticatable
{
    use Notifiable;

    protected $table = 'thisinh';

    protected $fillable = [
        'admin_id',
        'ho_ten',
        'email',
        'mat_khau',
        'so_dien_thoai',
        'ngay_sinh',
        'gioi_tinh',
        'so_cccd',
        'dia_chi',
        'tinh_thanh',
        'truong_thpt',
        'nam_tot_nghiep',
        'khu_vuc_uu_tien',
        'doi_tuong_uu_tien',
    ];

    protected $hidden = [
        'mat_khau',
        'remember_token',
    ];

    protected $casts = [
        'ngay_sinh' => 'date',
    ];

    public function getAuthPasswordName(): string
    {
        return 'mat_khau';
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}