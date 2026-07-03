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
        $dots = DotTuyenSinh::whereIn('trang_thai', ['dang_mo', 'da_cong_bo', 'chuan_bi'])
            ->withCount('chiTieu')
            ->withSum('chiTieu', 'chi_tieu_giao')
            ->orderBy('ngay_bat_dau', 'desc')
            ->get();

        $phuongThucs = PhuongThucXT::where('is_active', 1)->orderBy('id')->get();

        // Thống kê nhanh cho hero
        $soDotDangMo   = $dots->where('trang_thai', 'dang_mo')->count();
        $tongChiTieu   = ChiTieu::whereHas('dotTuyenSinh', fn($q) => $q->where('trang_thai', 'dang_mo'))
            ->sum('chi_tieu_giao');

        return view('tuyensinh::frontend.index', compact('dots', 'phuongThucs', 'soDotDangMo', 'tongChiTieu'));
    }

    public function show($id)
    {
        $dot = DotTuyenSinh::findOrFail($id);
        $chiTieus = ChiTieu::with(['nganhHoc.khoa', 'phuongThuc'])
            ->where('dot_tuyen_sinh_id', $id)
            ->get()
            ->groupBy(fn($ct) => $ct->nganhHoc->khoa->ten_khoa ?? 'Khác');

        $tongChiTieu = ChiTieu::where('dot_tuyen_sinh_id', $id)->sum('chi_tieu_giao');
        $tongDaTuyen = ChiTieu::where('dot_tuyen_sinh_id', $id)->sum('chi_tieu_da_tuyen');

        return view('tuyensinh::frontend.show', compact('dot', 'chiTieus', 'tongChiTieu', 'tongDaTuyen'));
    }
}