<?php
namespace Modules\DaoTao\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\DaoTao\Models\Khoa;

class KhoaController extends Controller
{
    public function index()
    {
        $khoas = Khoa::orderBy('thu_tu')->get();
        return view('daotao::khoa.index', compact('khoas'));
    }

    public function create()
    {
        return view('daotao::khoa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_khoa' => 'required|max:150',
            'ma_khoa'  => 'required|max:20|unique:khoa,ma_khoa',
            'email_khoa' => 'nullable|email',
        ]);
        Khoa::create($request->all());
        return redirect()->route('admin.khoa.index')->with('success', 'Thêm khoa thành công!');
    }

    public function edit($id)
    {
        $khoa = Khoa::findOrFail($id);
        return view('daotao::khoa.edit', compact('khoa'));
    }

    public function update(Request $request, $id)
    {
        $khoa = Khoa::findOrFail($id);
        $request->validate([
            'ten_khoa'   => 'required|max:150',
            'ma_khoa'    => 'required|max:20|unique:khoa,ma_khoa,' . $id,
            'email_khoa' => 'nullable|email',
        ]);
        $khoa->update($request->all());
        return redirect()->route('admin.khoa.index')->with('success', 'Cập nhật khoa thành công!');
    }

    public function destroy($id)
    {
        $khoa = Khoa::findOrFail($id);
        $khoa->delete();
        return redirect()->route('admin.khoa.index')->with('success', 'Xóa khoa thành công!');
    }
}