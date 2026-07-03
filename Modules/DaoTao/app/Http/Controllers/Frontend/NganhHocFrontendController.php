<?php
namespace Modules\DaoTao\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Modules\DaoTao\Models\NganhHoc;
use Modules\DaoTao\Models\Khoa;

class NganhHocFrontendController extends Controller
{
    public function index()
    {
        $nganhHocs = NganhHoc::with(['khoa', 'toHopMon', 'hocPhi'])
            ->where('trang_thai', 1)
            ->orderBy('ma_nganh')
            ->get();
        $khoas = Khoa::orderBy('thu_tu')->get();
        return view('daotao::frontend.nganh-hoc', compact('nganhHocs', 'khoas'));
    }

    public function show($id)
    {
        $nganhHoc = NganhHoc::with([
            'khoa', 'toHopMon', 'hocPhi',
            'chuongTrinhDaoTao'
        ])->where('trang_thai', 1)->findOrFail($id);
        return view('daotao::frontend.nganh-hoc-detail', compact('nganhHoc'));
    }
}