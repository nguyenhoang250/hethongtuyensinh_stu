<?php
namespace Modules\DaoTao\Models;

use Illuminate\Database\Eloquent\Model;

class HocPhi extends Model
{
    protected $table = 'hocphi';
    protected $fillable = [
        'nganh_hoc_id', 'nam_hoc', 'hoc_phi_mot_hk',
        'hoc_phi_tin_chi', 'ghi_chu'
    ];

    public function nganhHoc()
    {
        return $this->belongsTo(NganhHoc::class, 'nganh_hoc_id');
    }
}