<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        // ── 1. BANNER ────────────────────────────────────────────────────
        // Modules\NoiDung\Models\Banner
        $bannerList = DB::table('Banner')
            ->where('vi_tri', 'trang_chu')
            ->where('is_hien_thi', 1)
            ->where('ngay_bat_dau', '<=', now())
            ->where('ngay_ket_thuc', '>=', now())
            ->orderBy('thu_tu')
            ->get();

        // ── 2. PHƯƠNG THỨC XÉT TUYỂN ────────────────────────────────────
        // Modules\TuyenSinh\Models\PhuongThucXT
        $phuongThucList = DB::table('PhuongThucXT')
            ->where('is_active', 1)
            ->orderBy('id')
            ->get();

        // ── 3. KHOA ──────────────────────────────────────────────────────
        // Modules\DaoTao\Models\Khoa
        $khoaList = DB::table('Khoa')
            ->orderBy('thu_tu')
            ->get();

        // ── 4. NGÀNH HỌC + điểm chuẩn + chỉ tiêu ───────────────────────
        // Modules\DaoTao\Models\NganhHoc
        $nganhList = DB::table('NganhHoc as n')
            ->join('Khoa as k', 'k.id', '=', 'n.khoa_id')
            ->where('n.trang_thai', 1)
            ->select([
                'n.id',
                'n.ten_nganh',
                'n.khoa_id',
                'n.thoi_gian_dao_tao',
                'k.ma_khoa',
                // Điểm chuẩn mới nhất từ đợt đã công bố
                DB::raw('(
                    SELECT ct.diem_chuan
                    FROM ChiTieu ct
                    JOIN DotTuyenSinh dot ON dot.id = ct.dot_tuyen_sinh_id
                    WHERE ct.nganh_hoc_id = n.id
                      AND dot.trang_thai = "da_cong_bo"
                      AND ct.diem_chuan IS NOT NULL
                    ORDER BY dot.ngay_cong_bo DESC
                    LIMIT 1
                ) as diem_chuan'),
                // Tổng chỉ tiêu đợt mới nhất đang/đã mở
                DB::raw('(
                    SELECT SUM(ct2.chi_tieu_giao)
                    FROM ChiTieu ct2
                    JOIN DotTuyenSinh dot2 ON dot2.id = ct2.dot_tuyen_sinh_id
                    WHERE ct2.nganh_hoc_id = n.id
                      AND dot2.trang_thai IN ("dang_mo","da_cong_bo")
                    LIMIT 1
                ) as chi_tieu'),
            ])
            ->orderBy('n.khoa_id')
            ->get();

        // ── 5. TIN TỨC ───────────────────────────────────────────────────
        // Modules\NoiDung\Models\BaiViet
        $tinTucList = DB::table('BaiViet as bv')
            ->join('DanhMucBaiViet as dm', 'dm.id', '=', 'bv.danh_muc_id')
            ->where('bv.trang_thai', 'da_xuat_ban')
            ->where('bv.ngay_xuat_ban', '<=', now())
            ->orderByDesc('bv.ngay_xuat_ban')
            ->limit(4)
            ->select([
                'bv.id',
                'bv.tieu_de',
                'bv.slug',
                'bv.anh_dai_dien as anh',
                'bv.ngay_xuat_ban as ngay_dang',
                'dm.ten_danh_muc as danh_muc',
            ])
            ->get();

        // ── 6. SỰ KIỆN ───────────────────────────────────────────────────
        // Modules\SuKien\Models\SuKien
        $loaiMap = [
            'ngay_hoi_ts' => ['tag' => 'tuvan',    'label' => 'Tư vấn'],
            'hoi_thao'    => ['tag' => 'nganhhoc', 'label' => 'Hội thảo'],
            'livestream'  => ['tag' => 'tuvan',    'label' => 'Livestream'],
            'hoc_bong'    => ['tag' => 'hocbong',  'label' => 'Học bổng'],
            'workshop'    => ['tag' => 'nganhhoc', 'label' => 'Workshop'],
        ];

        $suKienList = DB::table('SuKien')
            ->where('is_hien_thi', 1)
            ->where('ngay_to_chuc', '>=', now())
            ->whereIn('trang_thai', ['sap_dien_ra', 'dang_mo'])
            ->orderBy('ngay_to_chuc')
            ->limit(4)
            ->get()
            ->map(function ($sk) use ($loaiMap) {
                $info = $loaiMap[$sk->loai_su_kien] ?? ['tag' => 'tuvan', 'label' => 'Sự kiện'];
                $sk->loai       = $info['tag'];
                $sk->loai_label = $info['label'];
                return $sk;
            });

        // ── 7. HỌC BỔNG ──────────────────────────────────────────────────
        // Modules\HocBong\Models\HocBong
        $iconMap = [
            'tan_sinh_vien' => ['fas fa-trophy', 'fas fa-star'],
            'tai_nang'      => ['fas fa-bolt',   'fas fa-bolt'],
            'ngheo_kho'     => ['fas fa-hand-holding-heart', 'fas fa-hand-holding-heart'],
        ];
        $classMap = ['red', 'gold', 'navy'];

        $hocBongList = DB::table('HocBong')
            ->where('trang_thai', 'dang_mo')
            ->where('ngay_bat_dau_dk', '<=', now())
            ->where('ngay_ket_thuc_dk', '>=', now())
            ->orderByDesc('phan_tram_mien_giam')
            ->limit(3)
            ->get()
            ->map(function ($hb, $i) use ($iconMap, $classMap) {
                $icons = $iconMap[$hb->loai_hoc_bong] ?? ['fas fa-award', 'fas fa-award'];
                $hb->card_class    = $classMap[$i] ?? 'navy';
                $hb->icon          = $icons[$i] ?? $icons[0];
                $hb->gia_tri_label = $hb->phan_tram_mien_giam == 100
                    ? 'Miễn 100% học phí'
                    : 'Giảm ' . (int)$hb->phan_tram_mien_giam . '% học phí';
                return $hb;
            });

        // ── 8. NGHIÊN CỨU KHOA HỌC ───────────────────────────────────────
        // BaiViet danh mục slug = 'nghien-cuu-khoa-hoc'
        $nckhList = DB::table('BaiViet as bv')
            ->join('DanhMucBaiViet as dm', 'dm.id', '=', 'bv.danh_muc_id')
            ->where('dm.slug', 'nghien-cuu-khoa-hoc')
            ->where('bv.trang_thai', 'da_xuat_ban')
            ->orderByDesc('bv.ngay_xuat_ban')
            ->limit(3)
            ->select([
                'bv.id',
                'bv.tieu_de',
                'bv.slug',
                'bv.anh_dai_dien as anh',
                'bv.tom_tat as mo_ta',
                'bv.ngay_xuat_ban as ngay',
            ])
            ->get();

        return view('pages.welcome', compact(
            'bannerList',
            'phuongThucList',
            'khoaList',
            'nganhList',
            'tinTucList',
            'suKienList',
            'hocBongList',
            'nckhList',
        ));
    }

    /**
     * POST /tu-van — Lưu vào bảng YeuCauTuVan
     */
    public function tuVan(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'ho_ten'        => 'required|string|max:100',
            'so_dien_thoai' => 'required|string|max:15',
            'email'         => 'nullable|email|max:150',
            'nganh_id'      => 'nullable|integer',
            'tinh_thanh'    => 'nullable|string|max:100',
        ]);

        DB::table('YeuCauTuVan')->insert([
            'thi_sinh_id'         => null,
            'nhan_vien_tu_van_id' => null,
            'tieu_de'             => 'Đăng ký tư vấn từ trang chủ',
            'noi_dung'            => json_encode([
                'ho_ten'        => $data['ho_ten'],
                'so_dien_thoai' => $data['so_dien_thoai'],
                'email'         => $data['email'] ?? null,
                'nganh_id'      => $data['nganh_id'] ?? null,
                'tinh_thanh'    => $data['tinh_thanh'] ?? null,
            ]),
            'kenh_tu_van'         => 'form_trang_chu',
            'muc_do_uu_tien'      => 'binh_thuong',
            'trang_thai'          => 'cho_xu_ly',
            'ngay_yeu_cau'        => now(),
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);

        return back()->with('success', 'Đăng ký thành công! Tư vấn viên STU sẽ liên hệ với bạn sớm nhất.');
    }
}