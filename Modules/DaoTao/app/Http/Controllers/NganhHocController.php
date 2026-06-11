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
            'khoa_id'  => 'required|exists:khoa,id',
            'ma_nganh' => 'required|max:20|unique:nganhhoc,ma_nganh',
            'ten_nganh' => 'required|max:200',
            'trinh_do' => 'required|in:dai_hoc,lien_thong',
            'thoi_gian_dao_tao' => 'required|integer|min:1|max:6',
        ]);
        NganhHoc::create($request->all());
        return redirect()->route('admin.nganh-hoc.index')->with('success', 'Thêm ngành học thành công!');
    }

    public function edit($id)
    {
        $nganhHoc = NganhHoc::findOrFail($id);
        $khoas = Khoa::orderBy('thu_tu')->get();
        return view('daotao::nganh-hoc.edit', compact('nganhHoc', 'khoas'));
    }

    public function update(Request $request, $id)
    {
        $nganhHoc = NganhHoc::findOrFail($id);
        $request->validate([
            'khoa_id'  => 'required|exists:khoa,id',
            'ma_nganh' => 'required|max:20|unique:nganhhoc,ma_nganh,' . $id,
            'ten_nganh' => 'required|max:200',
            'trinh_do' => 'required|in:dai_hoc,lien_thong',
            'thoi_gian_dao_tao' => 'required|integer|min:1|max:6',
        ]);
        $nganhHoc->update($request->all());
        return redirect()->route('admin.nganh-hoc.index')->with('success', 'Cập nhật ngành học thành công!');
    }

    public function destroy($id)
    {
        $nganhHoc = NganhHoc::findOrFail($id);
        $nganhHoc->delete();
        return redirect()->route('admin.nganh-hoc.index')->with('success', 'Xóa ngành học thành công!');
    }
}