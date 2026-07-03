<?php
namespace Modules\TuyenSinh\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DotTuyenSinh extends Model
{
    protected $table = 'dottuyensinh';
    protected $fillable = [
        'ma_dot', 'ten_dot', 'nam_hoc', 'ngay_bat_dau',
        'ngay_ket_thuc', 'ngay_cong_bo', 'trang_thai', 'ghi_chu'
    ];

    public function chiTieu()
    {
        return $this->hasMany(ChiTieu::class, 'dot_tuyen_sinh_id');
    }

    // ⭐ Tự tính trạng thái thực tế theo ngày — dùng ở Frontend thay cho trang_thai
    public function getTrangThaiThucTeAttribute(): string
    {
        if ($this->trang_thai === 'da_cong_bo') return 'da_cong_bo';
        if (Carbon::now()->lt(Carbon::parse($this->ngay_bat_dau))) return 'chuan_bi';
        if (Carbon::now()->gt(Carbon::parse($this->ngay_ket_thuc))) return 'da_dong';
        return 'dang_mo';
    }
}