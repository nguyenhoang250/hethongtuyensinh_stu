<?php
namespace Modules\TuyenSinh\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTieu extends Model
{
    protected $table = 'chitieu';
    protected $fillable = [
        'dot_tuyen_sinh_id', 'nganh_hoc_id', 'phuong_thuc_id',
        'chi_tieu_giao', 'chi_tieu_da_tuyen', 'diem_chuan', 'diem_san_nop_hs'
    ];

    public function dotTuyenSinh()
    {
        return $this->belongsTo(DotTuyenSinh::class, 'dot_tuyen_sinh_id');
    }

    public function nganhHoc()
    {
        return $this->belongsTo('Modules\DaoTao\Models\NganhHoc', 'nganh_hoc_id');
    }

    public function phuongThuc()
    {
        return $this->belongsTo(PhuongThucXT::class, 'phuong_thuc_id');
    }
}