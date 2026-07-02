<?php
namespace Modules\TuyenSinh\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Modules\TuyenSinh\Models\DotTuyenSinh;
use Modules\TuyenSinh\Models\PhuongThucXT;
use Modules\TuyenSinh\Models\ChiTieu;

class TuyenSinhFrontendController extends Controller
{
    public function index()
    {
        $dots = DotTuyenSinh::whereIn('trang_thai', ['dang_mo', 'da_cong_bo'])
            ->orderBy('ngay_bat_dau', 'desc')
            ->get();
        $phuongThucs = PhuongThucXT::orderBy('id')->get();
        return view('tuyensinh::frontend.index', compact('dots', 'phuongThucs'));
    }

    public function show($id)
    {
        $dot = DotTuyenSinh::findOrFail($id);
        $chiTieus = ChiTieu::with(['nganhHoc.khoa', 'phuongThuc'])
            ->where('dot_tuyen_sinh_id', $id)
            ->get();
        return view('tuyensinh::frontend.show', compact('dot', 'chiTieus'));
    }
}