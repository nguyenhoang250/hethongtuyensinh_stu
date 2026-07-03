<?php
namespace Modules\TuyenSinh\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\TuyenSinh\Models\ChiTieu;
use Modules\TuyenSinh\Models\DotTuyenSinh;
use Modules\TuyenSinh\Models\PhuongThucXT;
use Modules\DaoTao\Models\NganhHoc;

class ChiTieuController extends Controller
{
    public function index()
    {
        $chiTieus = ChiTieu::with(['dotTuyenSinh', 'nganhHoc', 'phuongThuc'])
            ->orderBy('dot_tuyen_sinh_id')
            ->get();
        return view('tuyensinh::chi-tieu.index', compact('chiTieus'));
    }

    public function create()
    {
        $dots        = DotTuyenSinh::orderBy('ngay_bat_dau', 'desc')->get();
        $nganhs      = NganhHoc::where('trang_thai', 1)->orderBy('ten_nganh')->get();
        $phuongThucs = PhuongThucXT::orderBy('id')->get();
        return view('tuyensinh::chi-tieu.create', compact('dots', 'nganhs', 'phuongThucs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dot_tuyen_sinh_id' => 'required|exists:dottuyensinh,id',
            'nganh_hoc_id'      => 'required|exists:nganhhoc,id',
            'phuong_thuc_id'    => 'required|exists:phuongthucxt,id',
            'chi_tieu_giao'     => 'required|integer|min:1',
            // ⭐ Chặn đã tuyển vượt chỉ tiêu giao
            'chi_tieu_da_tuyen' => 'nullable|integer|min:0|lte:chi_tieu_giao',
            'diem_san_nop_hs'   => 'nullable|numeric|min:0',
            // ⭐ Chặn điểm chuẩn thấp hơn điểm sàn
            'diem_chuan'        => 'nullable|numeric|min:0|gte:diem_san_nop_hs',
        ], [
            'dot_tuyen_sinh_id.required' => 'Vui lòng chọn đợt tuyển sinh.',
            'nganh_hoc_id.required'      => 'Vui lòng chọn ngành học.',
            'phuong_thuc_id.required'    => 'Vui lòng chọn phương thức xét tuyển.',
            'chi_tieu_giao.required'     => 'Vui lòng nhập chỉ tiêu giao.',
            // ⭐ Message rõ ràng cho 2 rule mới
            'chi_tieu_da_tuyen.lte'      => 'Số đã tuyển không được vượt quá chỉ tiêu giao.',
            'diem_chuan.gte'             => 'Điểm chuẩn không được thấp hơn điểm sàn nộp hồ sơ.',
        ]);

        // Chặn trùng tổ hợp Đợt + Ngành + Phương thức
        $trung = ChiTieu::where('dot_tuyen_sinh_id', $request->dot_tuyen_sinh_id)
            ->where('nganh_hoc_id', $request->nganh_hoc_id)
            ->where('phuong_thuc_id', $request->phuong_thuc_id)
            ->exists();

        if ($trung) {
            return back()->withErrors([
                'nganh_hoc_id' => 'Tổ hợp Đợt + Ngành + Phương thức này đã có chỉ tiêu, vui lòng sửa dòng cũ thay vì thêm mới.',
            ])->withInput();
        }

        ChiTieu::create([
            'dot_tuyen_sinh_id' => $request->dot_tuyen_sinh_id,
            'nganh_hoc_id'      => $request->nganh_hoc_id,
            'phuong_thuc_id'    => $request->phuong_thuc_id,
            'chi_tieu_giao'     => $request->chi_tieu_giao,
            'chi_tieu_da_tuyen' => $request->chi_tieu_da_tuyen ?? 0,
            'diem_chuan'        => $request->diem_chuan,
            'diem_san_nop_hs'   => $request->diem_san_nop_hs,
        ]);

        return redirect()->route('admin.chi-tieu.index')
            ->with('success', 'Thêm chỉ tiêu thành công!');
    }

    public function edit($id)
    {
        $chiTieu = ChiTieu::findOrFail($id);
        $dots    = DotTuyenSinh::orderBy('ngay_bat_dau', 'desc')->get();

        // Lấy ngành đang hoạt động + luôn kèm ngành hiện tại (dù đã dừng)
        $nganhs = NganhHoc::where('trang_thai', 1)
            ->orWhere('id', $chiTieu->nganh_hoc_id)
            ->orderBy('ten_nganh')
            ->get();

        $phuongThucs = PhuongThucXT::orderBy('id')->get();
        return view('tuyensinh::chi-tieu.edit', compact('chiTieu', 'dots', 'nganhs', 'phuongThucs'));
    }

    public function update(Request $request, $id)
    {
        $chiTieu = ChiTieu::findOrFail($id);

        $request->validate([
            'dot_tuyen_sinh_id' => 'required|exists:dottuyensinh,id',
            'nganh_hoc_id'      => 'required|exists:nganhhoc,id',
            'phuong_thuc_id'    => 'required|exists:phuongthucxt,id',
            'chi_tieu_giao'     => 'required|integer|min:1',
            // ⭐ Chặn đã tuyển vượt chỉ tiêu giao
            'chi_tieu_da_tuyen' => 'nullable|integer|min:0|lte:chi_tieu_giao',
            'diem_san_nop_hs'   => 'nullable|numeric|min:0',
            // ⭐ Chặn điểm chuẩn thấp hơn điểm sàn
            'diem_chuan'        => 'nullable|numeric|min:0|gte:diem_san_nop_hs',
        ], [
            'dot_tuyen_sinh_id.required' => 'Vui lòng chọn đợt tuyển sinh.',
            'nganh_hoc_id.required'      => 'Vui lòng chọn ngành học.',
            'phuong_thuc_id.required'    => 'Vui lòng chọn phương thức xét tuyển.',
            'chi_tieu_giao.required'     => 'Vui lòng nhập chỉ tiêu giao.',
            'chi_tieu_da_tuyen.lte'      => 'Số đã tuyển không được vượt quá chỉ tiêu giao.',
            'diem_chuan.gte'             => 'Điểm chuẩn không được thấp hơn điểm sàn nộp hồ sơ.',
        ]);

        // Chặn trùng tổ hợp (bỏ qua bản ghi hiện tại)
        $trung = ChiTieu::where('dot_tuyen_sinh_id', $request->dot_tuyen_sinh_id)
            ->where('nganh_hoc_id', $request->nganh_hoc_id)
            ->where('phuong_thuc_id', $request->phuong_thuc_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($trung) {
            return back()->withErrors([
                'nganh_hoc_id' => 'Tổ hợp Đợt + Ngành + Phương thức này đã có chỉ tiêu, vui lòng sửa dòng cũ thay vì thêm mới.',
            ])->withInput();
        }

        $chiTieu->update([
            'dot_tuyen_sinh_id' => $request->dot_tuyen_sinh_id,
            'nganh_hoc_id'      => $request->nganh_hoc_id,
            'phuong_thuc_id'    => $request->phuong_thuc_id,
            'chi_tieu_giao'     => $request->chi_tieu_giao,
            'chi_tieu_da_tuyen' => $request->chi_tieu_da_tuyen ?? 0,
            'diem_chuan'        => $request->diem_chuan,
            'diem_san_nop_hs'   => $request->diem_san_nop_hs,
        ]);

        return redirect()->route('admin.chi-tieu.index')
            ->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        ChiTieu::findOrFail($id)->delete();
        return redirect()->route('admin.chi-tieu.index')
            ->with('success', 'Xóa thành công!');
    }
}