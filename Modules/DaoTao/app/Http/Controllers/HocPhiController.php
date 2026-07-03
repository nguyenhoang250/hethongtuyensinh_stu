<?php
namespace Modules\DaoTao\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\DaoTao\Models\HocPhi;
use Modules\DaoTao\Models\NganhHoc;

class HocPhiController extends Controller
{
    public function index()
    {
        $hocPhis = HocPhi::with('nganhHoc')
            ->orderBy('nam_hoc', 'desc')
            ->get();
        return view('daotao::hoc-phi.index', compact('hocPhis'));
    }

    public function create()
    {
        $nganhHocs = NganhHoc::where('trang_thai', 1)
            ->orderBy('ten_nganh')
            ->get();
        return view('daotao::hoc-phi.create', compact('nganhHocs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nganh_hoc_id'    => 'required|exists:nganhhoc,id',
            'nam_hoc'         => [
                'required',
                'max:10',
                // Kiểm tra trùng năm học trong cùng ngành
                \Illuminate\Validation\Rule::unique('hocphi')
                    ->where('nganh_hoc_id', $request->nganh_hoc_id),
            ],
            'hoc_phi_mot_hk'  => 'required|numeric|min:0',
            'hoc_phi_tin_chi' => 'required|numeric|min:0',
            'ghi_chu'         => 'nullable|string|max:500',
        ], [
            'nganh_hoc_id.required'   => 'Vui lòng chọn ngành học.',
            'nganh_hoc_id.exists'     => 'Ngành học không hợp lệ.',
            'nam_hoc.required'        => 'Vui lòng nhập năm học.',
            'nam_hoc.unique'          => 'Ngành này đã có học phí cho năm học này!',
            'hoc_phi_mot_hk.required' => 'Vui lòng nhập học phí mỗi học kỳ.',
            'hoc_phi_mot_hk.numeric'  => 'Học phí phải là số.',
            'hoc_phi_tin_chi.required' => 'Vui lòng nhập học phí tín chỉ.',
            'hoc_phi_tin_chi.numeric'  => 'Học phí tín chỉ phải là số.',
        ]);

        HocPhi::create([
            'nganh_hoc_id'    => $request->nganh_hoc_id,
            'nam_hoc'         => $request->nam_hoc,
            'hoc_phi_mot_hk'  => $request->hoc_phi_mot_hk,
            'hoc_phi_tin_chi' => $request->hoc_phi_tin_chi,
            'ghi_chu'         => $request->ghi_chu,
        ]);

        return redirect()->route('admin.hoc-phi.index')
            ->with('success', 'Thêm học phí thành công!');
    }

    public function edit($id)
    {
        $hocPhi    = HocPhi::findOrFail($id);
        $nganhHocs = NganhHoc::where('trang_thai', 1)
            ->orderBy('ten_nganh')
            ->get();
        return view('daotao::hoc-phi.edit', compact('hocPhi', 'nganhHocs'));
    }

    public function update(Request $request, $id)
    {
        $hocPhi = HocPhi::findOrFail($id);
        $request->validate([
            'nganh_hoc_id'    => 'required|exists:nganhhoc,id',
            'nam_hoc'         => [
                'required',
                'max:10',
                // Bỏ qua bản ghi hiện tại khi kiểm tra trùng
                \Illuminate\Validation\Rule::unique('hocphi')
                    ->where('nganh_hoc_id', $request->nganh_hoc_id)
                    ->ignore($id),
            ],
            'hoc_phi_mot_hk'  => 'required|numeric|min:0',
            'hoc_phi_tin_chi' => 'required|numeric|min:0',
            'ghi_chu'         => 'nullable|string|max:500',
        ], [
            'nganh_hoc_id.required'    => 'Vui lòng chọn ngành học.',
            'nganh_hoc_id.exists'      => 'Ngành học không hợp lệ.',
            'nam_hoc.required'         => 'Vui lòng nhập năm học.',
            'nam_hoc.unique'           => 'Ngành này đã có học phí cho năm học này!',
            'hoc_phi_mot_hk.required'  => 'Vui lòng nhập học phí mỗi học kỳ.',
            'hoc_phi_mot_hk.numeric'   => 'Học phí phải là số.',
            'hoc_phi_tin_chi.required' => 'Vui lòng nhập học phí tín chỉ.',
            'hoc_phi_tin_chi.numeric'  => 'Học phí tín chỉ phải là số.',
        ]);

        $hocPhi->update([
            'nganh_hoc_id'    => $request->nganh_hoc_id,
            'nam_hoc'         => $request->nam_hoc,
            'hoc_phi_mot_hk'  => $request->hoc_phi_mot_hk,
            'hoc_phi_tin_chi' => $request->hoc_phi_tin_chi,
            'ghi_chu'         => $request->ghi_chu,
        ]);

        return redirect()->route('admin.hoc-phi.index')
            ->with('success', 'Cập nhật học phí thành công!');
    }

    public function destroy($id)
    {
        HocPhi::findOrFail($id)->delete();
        return redirect()->route('admin.hoc-phi.index')
            ->with('success', 'Xóa học phí thành công!');
    }

    // ===== ⭐ AJAX CRUD dùng trong modal "Xem chi tiết" =====

    public function apiStore(Request $request, $nganhId)
    {
        $nganhHoc = NganhHoc::findOrFail($nganhId);

        $data = $request->validate([
            'nam_hoc' => [
                'required',
                'max:10',
                \Illuminate\Validation\Rule::unique('hocphi')
                    ->where('nganh_hoc_id', $nganhHoc->id),
            ],
            'hoc_phi_mot_hk'  => 'required|numeric|min:0',
            'hoc_phi_tin_chi' => 'required|numeric|min:0',
            'ghi_chu'         => 'nullable|string|max:500',
        ], [
            'nam_hoc.required'         => 'Vui lòng nhập năm học.',
            'nam_hoc.unique'           => 'Ngành này đã có học phí cho năm học này!',
            'hoc_phi_mot_hk.required'  => 'Vui lòng nhập học phí mỗi học kỳ.',
            'hoc_phi_mot_hk.numeric'   => 'Học phí phải là số.',
            'hoc_phi_tin_chi.required' => 'Vui lòng nhập học phí tín chỉ.',
            'hoc_phi_tin_chi.numeric'  => 'Học phí tín chỉ phải là số.',
        ]);

        $item = HocPhi::create([
            'nganh_hoc_id'    => $nganhHoc->id,
            'nam_hoc'         => $data['nam_hoc'],
            'hoc_phi_mot_hk'  => $data['hoc_phi_mot_hk'],
            'hoc_phi_tin_chi' => $data['hoc_phi_tin_chi'],
            'ghi_chu'         => $data['ghi_chu'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thêm học phí thành công!',
            'item'    => [
                'id'                  => $item->id,
                'nam_hoc'             => $item->nam_hoc,
                'hoc_phi_mot_hk'      => $item->hoc_phi_mot_hk,
                'hoc_phi_tin_chi'     => $item->hoc_phi_tin_chi,
                'hoc_phi_mot_hk_fmt'  => number_format($item->hoc_phi_mot_hk, 0, ',', '.'),
                'hoc_phi_tin_chi_fmt' => number_format($item->hoc_phi_tin_chi, 0, ',', '.'),
                'ghi_chu'             => $item->ghi_chu,
            ],
        ]);
    }

    public function apiUpdate(Request $request, $id)
    {
        $item = HocPhi::findOrFail($id);

        $data = $request->validate([
            'nam_hoc' => [
                'required',
                'max:10',
                \Illuminate\Validation\Rule::unique('hocphi')
                    ->where('nganh_hoc_id', $item->nganh_hoc_id)
                    ->ignore($id),
            ],
            'hoc_phi_mot_hk'  => 'required|numeric|min:0',
            'hoc_phi_tin_chi' => 'required|numeric|min:0',
            'ghi_chu'         => 'nullable|string|max:500',
        ], [
            'nam_hoc.required'         => 'Vui lòng nhập năm học.',
            'nam_hoc.unique'           => 'Ngành này đã có học phí cho năm học này!',
            'hoc_phi_mot_hk.required'  => 'Vui lòng nhập học phí mỗi học kỳ.',
            'hoc_phi_mot_hk.numeric'   => 'Học phí phải là số.',
            'hoc_phi_tin_chi.required' => 'Vui lòng nhập học phí tín chỉ.',
            'hoc_phi_tin_chi.numeric'  => 'Học phí tín chỉ phải là số.',
        ]);

        $item->update([
            'nam_hoc'         => $data['nam_hoc'],
            'hoc_phi_mot_hk'  => $data['hoc_phi_mot_hk'],
            'hoc_phi_tin_chi' => $data['hoc_phi_tin_chi'],
            'ghi_chu'         => $data['ghi_chu'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật học phí thành công!',
            'item'    => [
                'id'                  => $item->id,
                'nam_hoc'             => $item->nam_hoc,
                'hoc_phi_mot_hk'      => $item->hoc_phi_mot_hk,
                'hoc_phi_tin_chi'     => $item->hoc_phi_tin_chi,
                'hoc_phi_mot_hk_fmt'  => number_format($item->hoc_phi_mot_hk, 0, ',', '.'),
                'hoc_phi_tin_chi_fmt' => number_format($item->hoc_phi_tin_chi, 0, ',', '.'),
                'ghi_chu'             => $item->ghi_chu,
            ],
        ]);
    }

    public function apiDestroy($id)
    {
        HocPhi::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa học phí thành công!',
        ]);
    }
}