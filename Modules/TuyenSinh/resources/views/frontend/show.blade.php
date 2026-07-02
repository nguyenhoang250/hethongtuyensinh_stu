@extends('layouts.app')
@section('title', $dot->ten_dot . ' — STU')
@section('content')
<style>
    .page-hero { background: linear-gradient(135deg, var(--navy) 0%, var(--blue) 100%); padding: 48px 0; color: white; }
    .page-hero h1 { font-family: var(--font-display); font-size: clamp(22px,3vw,34px); margin-bottom: 8px; }
    .hero-meta { display: flex; flex-wrap: wrap; gap: 20px; margin-top: 16px; }
    .hero-meta-item { display: flex; align-items: center; gap: 7px; font-size: 13.5px; }
    .hero-meta-item i { color: var(--gold); }
    .dot-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; }
    .badge-dang_mo { background: #d4edda; color: #155724; }
    .badge-da_cong_bo { background: #cce5ff; color: #004085; }
    .badge-da_dong { background: #f8d7da; color: #721c24; }
    .badge-chuan_bi { background: #e2e3e5; color: #383d41; }
    .ct-section { padding: 48px 0; }
    .ct-table { width: 100%; border-collapse: collapse; background: white; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-sm); }
    .ct-table th { background: var(--navy); color: white; padding: 12px 16px; text-align: left; font-size: 13px; }
    .ct-table td { padding: 12px 16px; font-size: 13.5px; border-bottom: 1px solid var(--gray-100); }
    .ct-table tr:last-child td { border-bottom: none; }
    .ct-table tr:hover td { background: var(--gray-50); }
    .diem-chuan { font-weight: 800; color: var(--red); font-size: 15px; }
    .breadcrumb-bar { background: var(--gray-50); border-bottom: 1px solid var(--gray-100); padding: 10px 0; }
    .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--gray-500); list-style: none; }
    .breadcrumb a { color: var(--navy); font-weight: 500; }
    .breadcrumb i { font-size: 10px; }
    .btn-dangky { display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; background: var(--red); color: white; border-radius: 50px; font-weight: 700; font-size: 14px; transition: all .2s; margin-top: 24px; }
    .btn-dangky:hover { background: var(--red-dark); transform: translateY(-2px); }
</style>

<div class="breadcrumb-bar">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}">Trang chủ</a></li>
            <li><i class="fas fa-chevron-right"></i></li>
            <li><a href="{{ route('tuyen-sinh.index') }}">Tuyển sinh</a></li>
            <li><i class="fas fa-chevron-right"></i></li>
            <li>{{ $dot->ten_dot }}</li>
        </ul>
    </div>
</div>

<div class="page-hero">
    <div class="container">
        @php $labels = ['chuan_bi'=>'Chuẩn bị','dang_mo'=>'Đang mở','da_dong'=>'Đã đóng','da_cong_bo'=>'Đã công bố']; @endphp
        <span class="dot-badge badge-{{ $dot->trang_thai }}">{{ $labels[$dot->trang_thai] ?? '' }}</span>
        <h1 class="mt-2">{{ $dot->ten_dot }}</h1>
        <div class="hero-meta">
            <div class="hero-meta-item"><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($dot->ngay_bat_dau)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($dot->ngay_ket_thuc)->format('d/m/Y') }}</div>
            <div class="hero-meta-item"><i class="fas fa-graduation-cap"></i> Năm học {{ $dot->nam_hoc }}</div>
            @if($dot->ngay_cong_bo)
            <div class="hero-meta-item"><i class="fas fa-bullhorn"></i> Công bố KQ: {{ \Carbon\Carbon::parse($dot->ngay_cong_bo)->format('d/m/Y') }}</div>
            @endif
        </div>
    </div>
</div>

<div class="ct-section">
    <div class="container">
        @if($dot->ghi_chu)
        <div class="alert alert-info mb-4"><i class="fas fa-info-circle"></i> {{ $dot->ghi_chu }}</div>
        @endif

        <table class="ct-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ngành Học</th>
                    <th>Khoa</th>
                    <th>Phương Thức</th>
                    <th>Chỉ Tiêu</th>
                    <th>Đã Tuyển</th>
                    <th>Điểm Chuẩn</th>
                    <th>Điểm Sàn</th>
                </tr>
            </thead>
            <tbody>
                @forelse($chiTieus as $ct)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{ url('/nganh-hoc/' . $ct->nganh_hoc_id) }}" style="color:var(--navy);font-weight:600">
                            {{ $ct->nganhHoc->ten_nganh ?? '—' }}
                        </a>
                        <div style="font-size:11px;color:var(--gray-500)">{{ $ct->nganhHoc->ma_nganh ?? '' }}</div>
                    </td>
                    <td style="font-size:12.5px">{{ $ct->nganhHoc->khoa->ten_khoa ?? '—' }}</td>
                    <td><span class="badge badge-info">{{ $ct->phuongThuc->ma_phuong_thuc ?? '—' }}</span></td>
                    <td class="text-center"><strong>{{ $ct->chi_tieu_giao }}</strong></td>
                    <td class="text-center">{{ $ct->chi_tieu_da_tuyen }}</td>
                    <td class="text-center">
                        @if($ct->diem_chuan)
                            <span class="diem-chuan">{{ $ct->diem_chuan }}</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $ct->diem_san_nop_hs ?? '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted">Chưa có chỉ tiêu cho đợt này.</td></tr>
                @endforelse
            </tbody>
        </table>

        <a href="{{ url('/ho-so/dang-ky') }}" class="btn-dangky">
            <i class="fas fa-edit"></i> Đăng ký xét tuyển ngay
        </a>
    </div>
</div>
@endsection