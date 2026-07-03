<?php
namespace Modules\DaoTao\Models;

use Illuminate\Database\Eloquent\Model;

class ChuongTrinhDaoTao extends Model
{
    protected $table = 'chuongtrinhdaotao';
    protected $fillable = [
        'nganh_hoc_id', 'nam_ban_hanh', 'tong_tin_chi',
        'ten_file', 'duong_dan_file', 'is_hien_thi'
    ];

    public function nganhHoc()
    {
        return $this->belongsTo(NganhHoc::class, 'nganh_hoc_id');
    }
}