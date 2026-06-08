<?php

namespace Modules\HeThong\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NhanVienTuVan extends Model
{
    protected $table = 'NhanVienTuVan';

    protected $fillable = [
        'admin_id',
        'ma_nhan_vien',
        'phong_ban',
        'chuyen_mon',
        'so_luong_tu_van',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}