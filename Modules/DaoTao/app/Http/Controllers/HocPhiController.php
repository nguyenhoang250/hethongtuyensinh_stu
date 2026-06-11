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
        $hocPhis = HocPhi::with('nganhHoc')->orderBy('nam_hoc', 'desc')->get();
        return view('daotao::hoc-phi.index', compact('hocPhis'));
    }

    public function create()
    {
        $nganhHocs = NganhHoc::where('trang_thai', 1)->orderBy('ten_nganh')->get();
        return view('daotao::hoc-phi.create', compact('nganhHocs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nganh_hoc_id'     => 'required|exists:nganhhoc,id',
            'nam_hoc'          => 'required|max:10',
            'hoc_phi_mot_hk'   => 'required|numeric|min:0',
            'hoc_phi_tin_chi'  => 'required|numeric|min:0',
        ]);
        HocPhi::create($request->all());
        return redirect()->route('admin.hoc-phi.index')->with('success', 'Thêm học phí thành công!');
    }

    public function edit($id)
    {
        $hocPhi = HocPhi::findOrFail($id);
        $nganhHocs = NganhHoc::where('trang_thai', 1)->orderBy('ten_nganh')->get();
        return view('daotao::hoc-phi.edit', compact('hocPhi', 'nganhHocs'));
    }

    public function update(Request $request, $id)
    {
        $hocPhi = HocPhi::findOrFail($id);
        $request->validate([
            'nganh_hoc_id'     => 'required|exists:nganhhoc,id',
            'nam_hoc'          => 'required|max:10',
            'hoc_phi_mot_hk'   => 'required|numeric|min:0',
            'hoc_phi_tin_chi'  => 'required|numeric|min:0',
        ]);
        $hocPhi->update($request->all());
        return redirect()->route('admin.hoc-phi.index')->with('success', 'Cập nhật học phí thành công!');
    }

    public function destroy($id)
    {
        HocPhi::findOrFail($id)->delete();
        return redirect()->route('admin.hoc-phi.index')->with('success', 'Xóa học phí thành công!');
    }
}