<?php
namespace Modules\DaoTao\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\DaoTao\Models\ToHopMon;
use Modules\DaoTao\Models\NganhHoc;

class ToHopMonController extends Controller
{
    // ===== CRUD gốc (giữ nguyên) =====

    public function index()
    {
        $toHopMons = ToHopMon::with('nganhHoc')->orderBy('ma_to_hop')->get();
        return view('daotao::to-hop-mon.index', compact('toHopMons'));
    }

    public function create()
    {
        $nganhHocs = NganhHoc::where('trang_thai', 1)->orderBy('ten_nganh')->get();
        return view('daotao::to-hop-mon.create', compact('nganhHocs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nganh_hoc_id' => 'required|exists:nganhhoc,id',
            'ma_to_hop'    => 'required|max:10',
            'ten_to_hop'   => 'required|max:100',
        ]);
        ToHopMon::create([
            'nganh_hoc_id' => $request->nganh_hoc_id,
            'ma_to_hop'    => $request->ma_to_hop,
            'ten_to_hop'   => $request->ten_to_hop,
            'is_chinh'     => $request->boolean('is_chinh'),   // ⭐ ép rõ true/false
        ]);
        return redirect()->route('admin.to-hop-mon.index')
            ->with('success', 'Thêm tổ hợp môn thành công!');
    }

    public function edit($id)
    {
        $toHopMon  = ToHopMon::findOrFail($id);
        $nganhHocs = NganhHoc::where('trang_thai', 1)->orderBy('ten_nganh')->get();
        return view('daotao::to-hop-mon.edit', compact('toHopMon', 'nganhHocs'));
    }

   public function update(Request $request, $id)
    {
        $toHopMon = ToHopMon::findOrFail($id);
        $request->validate([
            'nganh_hoc_id' => 'required|exists:nganhhoc,id',
            'ma_to_hop'    => 'required|max:10',
            'ten_to_hop'   => 'required|max:100',
        ]);
        $toHopMon->update([
            'nganh_hoc_id' => $request->nganh_hoc_id,
            'ma_to_hop'    => $request->ma_to_hop,
            'ten_to_hop'   => $request->ten_to_hop,
            'is_chinh'     => $request->boolean('is_chinh'),   // ⭐ ép rõ true/false
        ]);
        return redirect()->route('admin.to-hop-mon.index')
            ->with('success', 'Cập nhật tổ hợp môn thành công!');
    }

    public function destroy($id)
    {
        ToHopMon::findOrFail($id)->delete();
        return redirect()->route('admin.to-hop-mon.index')
            ->with('success', 'Xóa tổ hợp môn thành công!');
    }

    // ===== ⭐ CRUD theo Ngành (mới) =====

    // Hiện form thêm — ngành đã được chọn sẵn
    public function createTheoNganh($id)
    {
        $nganhHoc = NganhHoc::findOrFail($id);
        return view('daotao::nganh-hoc.to-hop-mon-form', compact('nganhHoc'));
    }

    // Lưu tổ hợp môn mới cho ngành
    public function storeTheoNganh(Request $request, $id)
    {
        $nganhHoc = NganhHoc::findOrFail($id);
        $request->validate([
            'ma_to_hop'  => 'required|max:10',
            'ten_to_hop' => 'required|max:100',
        ]);
        ToHopMon::create([
            'nganh_hoc_id' => $nganhHoc->id,
            'ma_to_hop'    => $request->ma_to_hop,
            'ten_to_hop'   => $request->ten_to_hop,
            'is_chinh'     => $request->boolean('is_chinh'),
        ]);
        return redirect()->route('admin.nganh-hoc.to-hop-mon', $nganhHoc->id)
            ->with('success', 'Thêm tổ hợp môn thành công!');
    }

    // Hiện form sửa — giữ context ngành
    public function editTheoNganh($nganh_id, $id)
    {
        $nganhHoc  = NganhHoc::findOrFail($nganh_id);
        $toHopMon  = ToHopMon::findOrFail($id);
        return view('daotao::nganh-hoc.to-hop-mon-form',
            compact('nganhHoc', 'toHopMon'));
    }

    // Cập nhật tổ hợp môn — giữ context ngành
    public function updateTheoNganh(Request $request, $nganh_id, $id)
    {
        $nganhHoc = NganhHoc::findOrFail($nganh_id);
        $toHopMon = ToHopMon::findOrFail($id);
        $request->validate([
            'ma_to_hop'  => 'required|max:10',
            'ten_to_hop' => 'required|max:100',
        ]);
        $toHopMon->update([
            'ma_to_hop'  => $request->ma_to_hop,
            'ten_to_hop' => $request->ten_to_hop,
            'is_chinh'   => $request->boolean('is_chinh'),
        ]);
        return redirect()->route('admin.nganh-hoc.to-hop-mon', $nganhHoc->id)
            ->with('success', 'Cập nhật tổ hợp môn thành công!');
    }

    // Xóa tổ hợp môn — quay lại danh sách ngành
    public function destroyTheoNganh($nganh_id, $id)
    {
        $nganhHoc = NganhHoc::findOrFail($nganh_id);
        ToHopMon::findOrFail($id)->delete();
        return redirect()->route('admin.nganh-hoc.to-hop-mon', $nganhHoc->id)
            ->with('success', 'Xóa tổ hợp môn thành công!');
    }

    // ===== ⭐ AJAX CRUD dùng trong modal "Xem chi tiết" =====

    public function apiStore(Request $request, $nganhId)
    {
        $nganhHoc = NganhHoc::findOrFail($nganhId);

        $data = $request->validate([
            'ma_to_hop'  => 'required|max:10',
            'ten_to_hop' => 'required|max:100',
        ], [
            'ma_to_hop.required'  => 'Vui lòng nhập mã tổ hợp.',
            'ten_to_hop.required' => 'Vui lòng nhập môn thi.',
        ]);

        $item = ToHopMon::create([
            'nganh_hoc_id' => $nganhHoc->id,
            'ma_to_hop'    => $data['ma_to_hop'],
            'ten_to_hop'   => $data['ten_to_hop'],
            'is_chinh'     => $request->boolean('is_chinh'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thêm tổ hợp môn thành công!',
            'item'    => [
                'id'         => $item->id,
                'ma_to_hop'  => $item->ma_to_hop,
                'ten_to_hop' => $item->ten_to_hop,
                'is_chinh'   => (bool) $item->is_chinh,
            ],
        ]);
    }

    public function apiUpdate(Request $request, $id)
    {
        $item = ToHopMon::findOrFail($id);

        $data = $request->validate([
            'ma_to_hop'  => 'required|max:10',
            'ten_to_hop' => 'required|max:100',
        ], [
            'ma_to_hop.required'  => 'Vui lòng nhập mã tổ hợp.',
            'ten_to_hop.required' => 'Vui lòng nhập môn thi.',
        ]);

        $item->update([
            'ma_to_hop'  => $data['ma_to_hop'],
            'ten_to_hop' => $data['ten_to_hop'],
            'is_chinh'   => $request->boolean('is_chinh'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật tổ hợp môn thành công!',
            'item'    => [
                'id'         => $item->id,
                'ma_to_hop'  => $item->ma_to_hop,
                'ten_to_hop' => $item->ten_to_hop,
                'is_chinh'   => (bool) $item->is_chinh,
            ],
        ]);
    }

    public function apiDestroy($id)
    {
        ToHopMon::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa tổ hợp môn thành công!',
        ]);
    }
}