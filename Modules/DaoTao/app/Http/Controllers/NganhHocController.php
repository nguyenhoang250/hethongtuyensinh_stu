<?php
namespace Modules\DaoTao\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\DaoTao\Models\NganhHoc;
use Modules\DaoTao\Models\Khoa;

class NganhHocController extends Controller
{
    public function index()
    {
        $nganhHocs = NganhHoc::with('khoa')->orderBy('ma_nganh')->get();
        return view('daotao::nganh-hoc.index', compact('nganhHocs'));
    }

    public function create()
    {
        $khoas = Khoa::orderBy('thu_tu')->get();
        return view('daotao::nganh-hoc.create', compact('khoas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'khoa_id'           => 'required|exists:khoa,id',
            'ma_nganh'          => 'required|max:20|unique:nganhhoc,ma_nganh',
            'ten_nganh'         => 'required|max:200',
            'ten_nganh_en'      => 'nullable|max:200',
            'trinh_do'          => 'required|in:dai_hoc,lien_thong',
            'thoi_gian_dao_tao' => 'required|integer|min:1|max:6',
            'mo_ta'             => 'nullable|string',
            'chuan_dau_ra'      => 'nullable|string',
        ], [
            'khoa_id.required'           => 'Vui lòng chọn khoa.',
            'khoa_id.exists'             => 'Khoa không hợp lệ.',
            'ma_nganh.required'          => 'Vui lòng nhập mã ngành.',
            'ma_nganh.unique'            => 'Mã ngành này đã tồn tại.',
            'ten_nganh.required'         => 'Vui lòng nhập tên ngành.',
            'trinh_do.required'          => 'Vui lòng chọn trình độ.',
            'thoi_gian_dao_tao.required' => 'Vui lòng nhập thời gian đào tạo.',
        ]);

        NganhHoc::create([
            'khoa_id'           => $request->khoa_id,
            'ma_nganh'          => $request->ma_nganh,
            'ten_nganh'         => $request->ten_nganh,
            'ten_nganh_en'      => $request->ten_nganh_en,
            'trinh_do'          => $request->trinh_do,
            'thoi_gian_dao_tao' => $request->thoi_gian_dao_tao,
            'mo_ta'             => $request->mo_ta,
            'chuan_dau_ra'      => $request->chuan_dau_ra,
            'trang_thai'        => $request->boolean('trang_thai') ? 1 : 0,
        ]);

        return redirect()->route('admin.nganh-hoc.index')
            ->with('success', 'Thêm ngành học thành công!');
    }

    /**
     * Trả JSON cho modal "Xem chi tiết" — gọi qua AJAX
     */
    public function show($id)
    {
        $nganh = NganhHoc::with([
            'khoa',
            'toHopMon',
            'hocPhi',
            'chuongTrinhDaoTao',
        ])->findOrFail($id);

        return response()->json([
            'id'           => $nganh->id,
            'ma_nganh'     => $nganh->ma_nganh,
            'ten_nganh'    => $nganh->ten_nganh,
            'ten_nganh_en' => $nganh->ten_nganh_en,
            'khoa'         => $nganh->khoa?->ten_khoa ?? '—',
            'trinh_do'     => $nganh->trinh_do === 'dai_hoc' ? 'Đại học' : 'Liên thông',
            'thoi_gian'    => $nganh->thoi_gian_dao_tao . ' năm',
            'mo_ta'        => $nganh->mo_ta,
            'chuan_dau_ra' => $nganh->chuan_dau_ra,
            'trang_thai'   => $nganh->trang_thai,

            'to_hop_mons' => $nganh->toHopMon->map(fn($t) => [
                'id'         => $t->id,
                'ma_to_hop'  => $t->ma_to_hop,
                'ten_to_hop' => $t->ten_to_hop,
                'is_chinh'   => (bool) $t->is_chinh,
            ]),

            'hoc_phis' => $nganh->hocPhi->map(fn($h) => [
                'id'                  => $h->id,
                'nam_hoc'             => $h->nam_hoc,
                'hoc_phi_mot_hk'      => $h->hoc_phi_mot_hk,
                'hoc_phi_tin_chi'     => $h->hoc_phi_tin_chi,
                'hoc_phi_mot_hk_fmt'  => number_format($h->hoc_phi_mot_hk, 0, ',', '.'),
                'hoc_phi_tin_chi_fmt' => number_format($h->hoc_phi_tin_chi, 0, ',', '.'),
                'ghi_chu'             => $h->ghi_chu,
            ]),

            'chuong_trinh_dao_taos' => $nganh->chuongTrinhDaoTao->map(fn($c) => [
                'id'           => $c->id,
                'nam_ban_hanh' => $c->nam_ban_hanh,
                'tong_tin_chi' => $c->tong_tin_chi,
                'ten_file'     => $c->ten_file,
                'url_file'     => $c->duong_dan_file ? asset('storage/' . $c->duong_dan_file) : null,
                'is_hien_thi'  => (bool) $c->is_hien_thi,
            ]),
        ]);
    }

    public function edit($id)
    {
        $nganhHoc = NganhHoc::findOrFail($id);
        $khoas    = Khoa::orderBy('thu_tu')->get();
        return view('daotao::nganh-hoc.edit', compact('nganhHoc', 'khoas'));
    }

    public function update(Request $request, $id)
    {
        $nganhHoc = NganhHoc::findOrFail($id);
        $request->validate([
            'khoa_id'           => 'required|exists:khoa,id',
            'ma_nganh'          => 'required|max:20|unique:nganhhoc,ma_nganh,' . $id,
            'ten_nganh'         => 'required|max:200',
            'ten_nganh_en'      => 'nullable|max:200',
            'trinh_do'          => 'required|in:dai_hoc,lien_thong',
            'thoi_gian_dao_tao' => 'required|integer|min:1|max:6',
            'mo_ta'             => 'nullable|string',
            'chuan_dau_ra'      => 'nullable|string',
        ], [
            'khoa_id.required'           => 'Vui lòng chọn khoa.',
            'ma_nganh.required'          => 'Vui lòng nhập mã ngành.',
            'ma_nganh.unique'            => 'Mã ngành này đã tồn tại.',
            'ten_nganh.required'         => 'Vui lòng nhập tên ngành.',
            'trinh_do.required'          => 'Vui lòng chọn trình độ.',
            'thoi_gian_dao_tao.required' => 'Vui lòng nhập thời gian đào tạo.',
        ]);

        $nganhHoc->update([
            'khoa_id'           => $request->khoa_id,
            'ma_nganh'          => $request->ma_nganh,
            'ten_nganh'         => $request->ten_nganh,
            'ten_nganh_en'      => $request->ten_nganh_en,
            'trinh_do'          => $request->trinh_do,
            'thoi_gian_dao_tao' => $request->thoi_gian_dao_tao,
            'mo_ta'             => $request->mo_ta,
            'chuan_dau_ra'      => $request->chuan_dau_ra,
            'trang_thai'        => $request->boolean('trang_thai') ? 1 : 0,
        ]);

        return redirect()->route('admin.nganh-hoc.index')
            ->with('success', 'Cập nhật ngành học thành công!');
    }

    public function destroy($id)
    {
        $nganhHoc = NganhHoc::findOrFail($id);

        if ($nganhHoc->toHopMon()->count() > 0) {
            return redirect()->route('admin.nganh-hoc.index')
                ->with('error', 'Không thể xóa ngành đang có ' . $nganhHoc->toHopMon()->count() . ' tổ hợp môn!');
        }
        if ($nganhHoc->hocPhi()->count() > 0) {
            return redirect()->route('admin.nganh-hoc.index')
                ->with('error', 'Không thể xóa ngành đang có dữ liệu học phí!');
        }
        if ($nganhHoc->chuongTrinhDaoTao()->count() > 0) {
            return redirect()->route('admin.nganh-hoc.index')
                ->with('error', 'Không thể xóa ngành đang có chương trình đào tạo!');
        }

        $nganhHoc->delete();
        return redirect()->route('admin.nganh-hoc.index')
            ->with('success', 'Xóa ngành học thành công!');
    }

    // Giữ lại nếu cần dùng trang riêng
    public function toHopMon($id)
    {
        $nganhHoc  = NganhHoc::with('toHopMon', 'khoa')->findOrFail($id);
        $toHopMons = $nganhHoc->toHopMon;
        return view('daotao::nganh-hoc.to-hop-mon', compact('nganhHoc', 'toHopMons'));
    }
}