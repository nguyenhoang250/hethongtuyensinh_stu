<?php
namespace Modules\DaoTao\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\DaoTao\Models\ToHopMon;
use Modules\DaoTao\Models\NganhHoc;

class ToHopMonController extends Controller
{
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
        ToHopMon::create($request->all());
        return redirect()->route('admin.to-hop-mon.index')->with('success', 'Thêm tổ hợp môn thành công!');
    }

    public function edit($id)
    {
        $toHopMon = ToHopMon::findOrFail($id);
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
        $toHopMon->update($request->all());
        return redirect()->route('admin.to-hop-mon.index')->with('success', 'Cập nhật tổ hợp môn thành công!');
    }

    public function destroy($id)
    {
        ToHopMon::findOrFail($id)->delete();
        return redirect()->route('admin.to-hop-mon.index')->with('success', 'Xóa tổ hợp môn thành công!');
    }
}