<?php
namespace Modules\DaoTao\Models;

use Illuminate\Database\Eloquent\Model;

class ToHopMon extends Model
{
    protected $table = 'tohopmon';
    protected $fillable = ['nganh_hoc_id', 'ma_to_hop', 'ten_to_hop', 'is_chinh'];

    public function nganhHoc()
    {
        return $this->belongsTo(NganhHoc::class, 'nganh_hoc_id');
    }
}