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
            'khoa_id.required'          => 'Vui lòng chọn khoa.',
            'khoa_id.exists'            => 'Khoa không hợp lệ.',
            'ma_nganh.required'         => 'Vui lòng nhập mã ngành.',
            'ma_nganh.unique'           => 'Mã ngành này đã tồn tại.',
            'ten_nganh.required'        => 'Vui lòng nhập tên ngành.',
            'trinh_do.required'         => 'Vui lòng chọn trình độ.',
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
            'khoa_id.required'          => 'Vui lòng chọn khoa.',
            'khoa_id.exists'            => 'Khoa không hợp lệ.',
            'ma_nganh.required'         => 'Vui lòng nhập mã ngành.',
            'ma_nganh.unique'           => 'Mã ngành này đã tồn tại.',
            'ten_nganh.required'        => 'Vui lòng nhập tên ngành.',
            'trinh_do.required'         => 'Vui lòng chọn trình độ.',
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

        // 🔴 Kiểm tra ràng buộc trước khi xóa
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

    // ⭐ Xem tổ hợp môn theo ngành
    public function toHopMon($id)
    {
        $nganhHoc  = NganhHoc::with('toHopMon', 'khoa')->findOrFail($id);
        $toHopMons = $nganhHoc->toHopMon;
        return view('daotao::nganh-hoc.to-hop-mon', compact('nganhHoc', 'toHopMons'));
    }
}