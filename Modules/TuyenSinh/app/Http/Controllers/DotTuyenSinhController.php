<?php
namespace Modules\TuyenSinh\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\TuyenSinh\Models\DotTuyenSinh;

class DotTuyenSinhController extends Controller
{
    public function index()
    {
        $dots = DotTuyenSinh::orderBy('ngay_bat_dau', 'desc')->get();
        return view('tuyensinh::dot-tuyen-sinh.index', compact('dots'));
    }

    public function create()
    {
        return view('tuyensinh::dot-tuyen-sinh.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_dot'        => 'required|max:20|unique:dottuyensinh,ma_dot',
            'ten_dot'       => 'required|max:200',
            'nam_hoc'       => 'required|max:10',
            'ngay_bat_dau'  => 'required|date',
            'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
            'ngay_cong_bo'  => 'nullable|date',
            'trang_thai'    => 'required|in:chuan_bi,dang_mo,da_dong,da_cong_bo',
            'ghi_chu'       => 'nullable|string',
        ], [
            'ma_dot.required'        => 'Vui lòng nhập mã đợt.',
            'ma_dot.unique'          => 'Mã đợt này đã tồn tại.',
            'ten_dot.required'       => 'Vui lòng nhập tên đợt.',
            'nam_hoc.required'       => 'Vui lòng nhập năm học.',
            'ngay_bat_dau.required'  => 'Vui lòng chọn ngày bắt đầu.',
            'ngay_ket_thuc.required' => 'Vui lòng chọn ngày kết thúc.',
            'ngay_ket_thuc.after'    => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);

        DotTuyenSinh::create([
            'ma_dot'        => $request->ma_dot,
            'ten_dot'       => $request->ten_dot,
            'nam_hoc'       => $request->nam_hoc,
            'ngay_bat_dau'  => $request->ngay_bat_dau,
            'ngay_ket_thuc' => $request->ngay_ket_thuc,
            'ngay_cong_bo'  => $request->ngay_cong_bo,
            'trang_thai'    => $request->trang_thai,
            'ghi_chu'       => $request->ghi_chu,
        ]);

        return redirect()->route('admin.dot-tuyen-sinh.index')
            ->with('success', 'Thêm đợt tuyển sinh thành công!');
    }

    public function edit($id)
    {
        $dot = DotTuyenSinh::findOrFail($id);
        return view('tuyensinh::dot-tuyen-sinh.edit', compact('dot'));
    }

    public function update(Request $request, $id)
    {
        $dot = DotTuyenSinh::findOrFail($id);
        $request->validate([
            'ma_dot'        => 'required|max:20|unique:dottuyensinh,ma_dot,' . $id,
            'ten_dot'       => 'required|max:200',
            'nam_hoc'       => 'required|max:10',
            'ngay_bat_dau'  => 'required|date',
            'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
            'ngay_cong_bo'  => 'nullable|date',
            'trang_thai'    => 'required|in:chuan_bi,dang_mo,da_dong,da_cong_bo',
            'ghi_chu'       => 'nullable|string',
        ], [
            'ma_dot.required'        => 'Vui lòng nhập mã đợt.',
            'ma_dot.unique'          => 'Mã đợt này đã tồn tại.',
            'ten_dot.required'       => 'Vui lòng nhập tên đợt.',
            'nam_hoc.required'       => 'Vui lòng nhập năm học.',
            'ngay_bat_dau.required'  => 'Vui lòng chọn ngày bắt đầu.',
            'ngay_ket_thuc.required' => 'Vui lòng chọn ngày kết thúc.',
            'ngay_ket_thuc.after'    => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);

        $dot->update([
            'ma_dot'        => $request->ma_dot,
            'ten_dot'       => $request->ten_dot,
            'nam_hoc'       => $request->nam_hoc,
            'ngay_bat_dau'  => $request->ngay_bat_dau,
            'ngay_ket_thuc' => $request->ngay_ket_thuc,
            'ngay_cong_bo'  => $request->ngay_cong_bo,
            'trang_thai'    => $request->trang_thai,
            'ghi_chu'       => $request->ghi_chu,
        ]);

        return redirect()->route('admin.dot-tuyen-sinh.index')
            ->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $dot = DotTuyenSinh::findOrFail($id);

        // 🔴 Kiểm tra ràng buộc trước khi xóa
        if ($dot->chiTieu()->count() > 0) {
            return redirect()->route('admin.dot-tuyen-sinh.index')
                ->with('error', 'Không thể xóa đợt tuyển sinh đang có ' . $dot->chiTieu()->count() . ' chỉ tiêu!');
        }

        $dot->delete();
        return redirect()->route('admin.dot-tuyen-sinh.index')
            ->with('success', 'Xóa thành công!');
    }
}