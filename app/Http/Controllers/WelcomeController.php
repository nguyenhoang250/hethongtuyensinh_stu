<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class WelcomeController extends Controller
{
    /**
     * Trang chủ tuyển sinh STU 2026.
     */
    public function index(): View
    {
        // Thay bằng query thật khi có model —————————————————————
        // $phuongThucList = PhuongThuc::orderBy('ma_phuong_thuc')->get();
        // $khoaList       = Khoa::orderBy('thu_tu')->get();
        // $nganhList      = Nganh::where('hien_thi', 1)->orderBy('thu_tu')->take(8)->get();
        // $tinTucList     = TinTuc::where('trang_thai', 'published')->latest('ngay_dang')->take(3)->get();
        // $suKienList     = SuKien::where('ngay_to_chuc', '>=', now())->orderBy('ngay_to_chuc')->take(4)->get();
        // $hocBongList    = HocBong::where('hien_thi', 1)->orderBy('thu_tu')->take(3)->get();
        // $nckhList       = NghienCuu::latest()->take(3)->get();
        // ————————————————————————————————————————————————————————

        // Trả null/[] → view tự dùng fallback tĩnh
        return view('pages.welcome', [
            'phuongThucList' => [],
            'khoaList'       => [],
            'nganhList'      => [],
            'tinTucList'     => [],
            'suKienList'     => [],
            'hocBongList'    => [],
            'nckhList'       => [],
        ]);
    }
}




// <?php

// namespace App\Http\Controllers;

// use Illuminate\View\View;
// use App\Models\PhuongThuc;
// use App\Models\Khoa;
// use App\Models\Nganh;
// use App\Models\TinTuc;
// use App\Models\SuKien;
// use App\Models\HocBong;
// use App\Models\NghienCuu;

// class WelcomeController extends Controller
// {
//     public function index(): View
//     {
//         return view('pages.welcome', [
//             'phuongThucList' => PhuongThuc::orderBy('ma_phuong_thuc')->get(),
//             'khoaList'       => Khoa::orderBy('thu_tu')->get(),
//             'nganhList'      => Nganh::where('hien_thi', 1)->orderBy('thu_tu')->take(8)->get(),
//             'tinTucList'     => TinTuc::where('trang_thai', 'published')->latest('ngay_dang')->take(3)->get(),
//             'suKienList'     => SuKien::where('ngay_to_chuc', '>=', now())->orderBy('ngay_to_chuc')->take(4)->get(),
//             'hocBongList'    => HocBong::where('hien_thi', 1)->orderBy('thu_tu')->take(3)->get(),
//             'nckhList'       => NghienCuu::latest()->take(3)->get(),
//         ]);
//     }
// }