<?php

namespace Modules\HeThong\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\HeThong\Models\ThiSinh;

class ThiSinhController extends Controller
{
    public function index()
    {
        $danhSach = ThiSinh::latest()->paginate(20);
        return view('hethong::admin.thi-sinh.index', compact('danhSach'));
    }
}