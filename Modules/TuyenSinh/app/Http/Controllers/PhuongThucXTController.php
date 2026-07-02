<?php
namespace Modules\TuyenSinh\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\TuyenSinh\Models\PhuongThucXT;

class PhuongThucXTController extends Controller
{
    public function index()
    {
        $phuongThucs = PhuongThucXT::orderBy('id')->get();
        return view('tuyensinh::phuong-thuc-xt.index', compact('phuongThucs'));
    }

    public function create()
    {
        return view('tuyensinh::phuong-thuc-xt.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_phuong_thuc'  => 'required|max:10|unique:phuongthucxt,ma_phuong_thuc',
            'ten_phuong_thuc' => 'required|max:200',
            'loai_diem'       => 'required|in:hoc_ba,thi_thpt,danh_gia_nang_luc',
        ], [
            'ma_phuong_thuc.required'  => 'Vui lòng nhập mã phương thức.',
            'ma_phuong_thuc.unique'    => 'Mã phương thức này đã tồn tại.',
            'ten_phuong_thuc.required' => 'Vui lòng nhập tên phương thức.',
            'loai_diem.required'       => 'Vui lòng chọn loại điểm.',
        ]);

        PhuongThucXT::create([
            'ma_phuong_thuc'  => $request->ma_phuong_thuc,
            'ten_phuong_thuc' => $request->ten_phuong_thuc,
            'mo_ta'           => $request->mo_ta,
            'loai_diem'       => $request->loai_diem,
            'is_active'       => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.phuong-thuc-xt.index')
            ->with('success', 'Thêm phương thức xét tuyển thành công!');
    }

    public function edit($id)
    {
        $phuongThuc = PhuongThucXT::findOrFail($id);
        return view('tuyensinh::phuong-thuc-xt.edit', compact('phuongThuc'));
    }

    public function update(Request $request, $id)
    {
        $phuongThuc = PhuongThucXT::findOrFail($id);
        $request->validate([
            'ma_phuong_thuc'  => 'required|max:10|unique:phuongthucxt,ma_phuong_thuc,' . $id,
            'ten_phuong_thuc' => 'required|max:200',
            'loai_diem'       => 'required|in:hoc_ba,thi_thpt,danh_gia_nang_luc',
        ], [
            'ma_phuong_thuc.required'  => 'Vui lòng nhập mã phương thức.',
            'ma_phuong_thuc.unique'    => 'Mã phương thức này đã tồn tại.',
            'ten_phuong_thuc.required' => 'Vui lòng nhập tên phương thức.',
            'loai_diem.required'       => 'Vui lòng chọn loại điểm.',
        ]);

        $phuongThuc->update([
            'ma_phuong_thuc'  => $request->ma_phuong_thuc,
            'ten_phuong_thuc' => $request->ten_phuong_thuc,
            'mo_ta'           => $request->mo_ta,
            'loai_diem'       => $request->loai_diem,
            'is_active'       => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.phuong-thuc-xt.index')
            ->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $phuongThuc = PhuongThucXT::findOrFail($id);

        // 🔴 Kiểm tra ràng buộc trước khi xóa
        if ($phuongThuc->chiTieu()->count() > 0) {
            return redirect()->route('admin.phuong-thuc-xt.index')
                ->with('error', 'Không thể xóa phương thức đang có ' . $phuongThuc->chiTieu()->count() . ' chỉ tiêu tuyển sinh!');
        }

        $phuongThuc->delete();
        return redirect()->route('admin.phuong-thuc-xt.index')
            ->with('success', 'Xóa thành công!');
    }
}