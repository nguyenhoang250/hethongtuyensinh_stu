<?php
namespace Modules\DaoTao\Models;

use Illuminate\Database\Eloquent\Model;

class Khoa extends Model
{
    protected $table = 'khoa';

    protected $fillable = [
        'ten_khoa', 'ma_khoa', 'dia_chi_khoa',
        'email_khoa', 'mo_ta', 'thu_tu',
    ];

    public function nganhHoc()
    {
        return $this->hasMany(NganhHoc::class, 'khoa_id');
    }
}