<?php
namespace Modules\TuyenSinh\Models;

use Illuminate\Database\Eloquent\Model;

class PhuongThucXT extends Model
{
  protected $table = 'phuongthucxt';
protected $fillable = [
    'ma_phuong_thuc', 'ten_phuong_thuc', 'mo_ta', 'loai_diem', 'is_active'
];

    public function chiTieu()
    {
        return $this->hasMany(ChiTieu::class, 'phuong_thuc_id');
    }
}