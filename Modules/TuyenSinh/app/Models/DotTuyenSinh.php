<?php
namespace Modules\TuyenSinh\Models;

use Illuminate\Database\Eloquent\Model;

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
}