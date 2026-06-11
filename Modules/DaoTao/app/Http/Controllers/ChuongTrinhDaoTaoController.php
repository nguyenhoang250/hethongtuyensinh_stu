<?php
namespace Modules\DaoTao\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\DaoTao\Models\ChuongTrinhDaoTao;
use Modules\DaoTao\Models\NganhHoc;
use Illuminate\Support\Facades\Storage;

class ChuongTrinhDaoTaoController extends Controller
{
    public function index()
    {
        $ctdts = ChuongTrinhDaoTao::with('nganhHoc')->orderBy('nam_ban_hanh', 'desc')->get();
        return view('daotao::chuong-trinh-dao-tao.index', compact('ctdts'));
    }

    public function create()
    {
        $nganhHocs = NganhHoc::where('trang_thai', 1)->orderBy('ten_nganh')->get();
        return view('daotao::chuong-trinh-dao-tao.create', compact('nganhHocs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nganh_hoc_id'  => 'required|exists:nganhhoc,id',
            'nam_ban_hanh'  => 'required|digits:4',
            'tong_tin_chi'  => 'required|integer|min:1',
            'file_ctdt'     => 'required|file|mimes:pdf|max:10240',
        ]);

        $file = $request->file('file_ctdt');
        $tenFile = $file->getClientOriginalName();
        $duongDan = $file->store('ctdt', 'public');

        ChuongTrinhDaoTao::create([
            'nganh_hoc_id'  => $request->nganh_hoc_id,
            'nam_ban_hanh'  => $request->nam_ban_hanh,
            'tong_tin_chi'  => $request->tong_tin_chi,
            'ten_file'      => $tenFile,
            'duong_dan_file' => $duongDan,
            'is_hien_thi'   => $request->has('is_hien_thi') ? 1 : 0,
        ]);

        return redirect()->route('admin.chuong-trinh-dao-tao.index')->with('success', 'Thêm chương trình đào tạo thành công!');
    }

    public function edit($id)
    {
        $ctdt = ChuongTrinhDaoTao::findOrFail($id);
        $nganhHocs = NganhHoc::where('trang_thai', 1)->orderBy('ten_nganh')->get();
        return view('daotao::chuong-trinh-dao-tao.edit', compact('ctdt', 'nganhHocs'));
    }

    public function update(Request $request, $id)
    {
        $ctdt = ChuongTrinhDaoTao::findOrFail($id);
        $request->validate([
            'nganh_hoc_id' => 'required|exists:nganhhoc,id',
            'nam_ban_hanh' => 'required|digits:4',
            'tong_tin_chi' => 'required|integer|min:1',
            'file_ctdt'    => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $data = $request->only(['nganh_hoc_id', 'nam_ban_hanh', 'tong_tin_chi']);
        $data['is_hien_thi'] = $request->has('is_hien_thi') ? 1 : 0;

        if ($request->hasFile('file_ctdt')) {
            Storage::disk('public')->delete($ctdt->duong_dan_file);
            $file = $request->file('file_ctdt');
            $data['ten_file'] = $file->getClientOriginalName();
            $data['duong_dan_file'] = $file->store('ctdt', 'public');
        }

        $ctdt->update($data);
        return redirect()->route('admin.chuong-trinh-dao-tao.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $ctdt = ChuongTrinhDaoTao::findOrFail($id);
        Storage::disk('public')->delete($ctdt->duong_dan_file);
        $ctdt->delete();
        return redirect()->route('admin.chuong-trinh-dao-tao.index')->with('success', 'Xóa thành công!');
    }
}