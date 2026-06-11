<?php
namespace Modules\DaoTao\Models;

use Illuminate\Database\Eloquent\Model;

class NganhHoc extends Model
{
    protected $table = 'nganhhoc';
    protected $fillable = [
        'khoa_id', 'ma_nganh', 'ten_nganh', 'ten_nganh_en',
        'trinh_do', 'thoi_gian_dao_tao', 'mo_ta', 'chuan_dau_ra', 'trang_thai'
    ];

    public function khoa()
    {
        return $this->belongsTo(Khoa::class, 'khoa_id');
    }

    public function toHopMon()
    {
        return $this->hasMany(ToHopMon::class, 'nganh_hoc_id');
    }

    public function hocPhi()
    {
        return $this->hasMany(HocPhi::class, 'nganh_hoc_id');
    }

    public function chuongTrinhDaoTao()
    {
        return $this->hasMany(ChuongTrinhDaoTao::class, 'nganh_hoc_id');
    }
}