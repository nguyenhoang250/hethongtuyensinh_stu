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
            'ten_khoa'     => 'required|max:150',
            'ma_khoa'      => 'required|max:20|unique:khoa,ma_khoa',
            'email_khoa'   => 'nullable|email|max:150',
            'dia_chi_khoa' => 'nullable|max:255',
            'thu_tu'       => 'nullable|integer|min:0',
        ], [
            'ten_khoa.required' => 'Vui lòng nhập tên khoa.',
            'ma_khoa.required'  => 'Vui lòng nhập mã khoa.',
            'ma_khoa.unique'    => 'Mã khoa này đã tồn tại.',
            'email_khoa.email'  => 'Email không đúng định dạng.',
        ]);

        Khoa::create([
            'ten_khoa'     => $request->ten_khoa,
            'ma_khoa'      => $request->ma_khoa,
            'dia_chi_khoa' => $request->dia_chi_khoa,
            'email_khoa'   => $request->email_khoa,
            'mo_ta'        => $request->mo_ta,
            'thu_tu'       => $request->thu_tu ?? 0,
        ]);

        return redirect()->route('admin.khoa.index')
            ->with('success', 'Thêm khoa thành công!');
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
            'ten_khoa'     => 'required|max:150',
            'ma_khoa'      => 'required|max:20|unique:khoa,ma_khoa,' . $id,
            'email_khoa'   => 'nullable|email|max:150',
            'dia_chi_khoa' => 'nullable|max:255',
            'thu_tu'       => 'nullable|integer|min:0',
        ], [
            'ten_khoa.required' => 'Vui lòng nhập tên khoa.',
            'ma_khoa.required'  => 'Vui lòng nhập mã khoa.',
            'ma_khoa.unique'    => 'Mã khoa này đã tồn tại.',
            'email_khoa.email'  => 'Email không đúng định dạng.',
        ]);

        $khoa->update([
            'ten_khoa'     => $request->ten_khoa,
            'ma_khoa'      => $request->ma_khoa,
            'dia_chi_khoa' => $request->dia_chi_khoa,
            'email_khoa'   => $request->email_khoa,
            'mo_ta'        => $request->mo_ta,
            'thu_tu'       => $request->thu_tu ?? 0,
        ]);

        return redirect()->route('admin.khoa.index')
            ->with('success', 'Cập nhật khoa thành công!');
    }

    public function destroy($id)
    {
        $khoa = Khoa::findOrFail($id);

        if ($khoa->nganhHoc()->count() > 0) {
            return redirect()->route('admin.khoa.index')
                ->with('error', 'Không thể xóa khoa đang có ' . $khoa->nganhHoc()->count() . ' ngành học!');
        }

        $khoa->delete();
        return redirect()->route('admin.khoa.index')
            ->with('success', 'Xóa khoa thành công!');
    }
}