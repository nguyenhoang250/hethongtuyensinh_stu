@extends('layouts.app')
@section('title', 'Tuyển Sinh — STU 2026')
@section('content')
<style>
    .page-hero { background: linear-gradient(135deg, var(--navy) 0%, var(--blue) 100%); padding: 56px 0 48px; color: white; }
    .page-hero h1 { font-family: var(--font-display); font-size: clamp(28px,4vw,42px); margin-bottom: 12px; }
    .page-hero p { font-size: 15px; opacity: .8; max-width: 560px; }
    .ts-section { padding: 48px 0; }
    .pt-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-bottom: 48px; }
    .pt-card { background: white; border: 1px solid var(--gray-100); border-radius: var(--radius-lg); padding: 24px; transition: all .25s; }
    .pt-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-hover); }
    .pt-ma { display: inline-block; background: var(--navy); color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; margin-bottom: 10px; }
    .pt-ten { font-family: var(--font-display); font-size: 16px; color: var(--navy); margin-bottom: 8px; }
    .pt-mo-ta { font-size: 13px; color: var(--gray-500); line-height: 1.6; margin-bottom: 12px; }
    .pt-dieu-kien { font-size: 12.5px; color: var(--gray-600); background: var(--gray-50); padding: 10px 12px; border-radius: 8px; border-left: 3px solid var(--navy); }
    .dot-list { display: flex; flex-direction: column; gap: 16px; }
    .dot-card { background: white; border: 1px solid var(--gray-100); border-radius: var(--radius-lg); padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; transition: all .25s; }
    .dot-card:hover { box-shadow: var(--shadow-hover); border-color: var(--gray-300); }
    .dot-info { flex: 1; }
    .dot-ma { font-size: 11px; font-weight: 700; color: var(--gray-500); letter-spacing: .08em; margin-bottom: 4px; }
    .dot-ten { font-family: var(--font-display); font-size: 17px; color: var(--navy); margin-bottom: 6px; }
    .dot-meta { display: flex; gap: 16px; }
    .dot-meta-item { font-size: 12.5px; color: var(--gray-500); display: flex; align-items: center; gap: 5px; }
    .dot-meta-item i { color: var(--navy); }
    .dot-badge { padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; }
    .badge-dang_mo { background: #d4edda; color: #155724; }
    .badge-da_cong_bo { background: #cce5ff; color: #004085; }
    .badge-da_dong { background: #f8d7da; color: #721c24; }
    .badge-chuan_bi { background: #e2e3e5; color: #383d41; }
    .btn-xem { padding: 8px 20px; background: var(--navy); color: white; border-radius: 50px; font-size: 13px; font-weight: 600; transition: all .2s; white-space: nowrap; margin-left: 16px; }
    .btn-xem:hover { background: var(--red); }
    .section-title { font-family: var(--font-display); font-size: 22px; color: var(--navy); margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid var(--gray-100); }
</style>

<div class="page-hero">
    <div class="container">
        <div class="section-label">Tuyển sinh</div>
        <h1>Thông tin Tuyển Sinh STU</h1>
        <p>Tìm hiểu các đợt tuyển sinh và phương thức xét tuyển tại Đại học Công nghệ Sài Gòn.</p>
    </div>
</div>

<div class="ts-section">
    <div class="container">

        {{-- Đợt tuyển sinh --}}
        <h2 class="section-title"><i class="fas fa-calendar-alt"></i> Các Đợt Tuyển Sinh</h2>
        <div class="dot-list">
            @forelse($dots as $dot)
            <div class="dot-card">
                <div class="dot-info">
                    <div class="dot-ma">{{ $dot->ma_dot }}</div>
                    <div class="dot-ten">{{ $dot->ten_dot }}</div>
                    <div class="dot-meta">
                        <div class="dot-meta-item">
                            <i class="fas fa-calendar"></i>
                            {{ \Carbon\Carbon::parse($dot->ngay_bat_dau)->format('d/m/Y') }}
                            — {{ \Carbon\Carbon::parse($dot->ngay_ket_thuc)->format('d/m/Y') }}
                        </div>
                        <div class="dot-meta-item">
                            <i class="fas fa-graduation-cap"></i>
                            {{ $dot->nam_hoc }}
                        </div>
                        @if($dot->ngay_cong_bo)
                        <div class="dot-meta-item">
                            <i class="fas fa-bullhorn"></i>
                            Công bố: {{ \Carbon\Carbon::parse($dot->ngay_cong_bo)->format('d/m/Y') }}
                        </div>
                        @endif
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:12px">
                    @php
                        $labels = ['chuan_bi'=>'Chuẩn bị','dang_mo'=>'Đang mở','da_dong'=>'Đã đóng','da_cong_bo'=>'Đã công bố'];
                    @endphp
                    <span class="dot-badge badge-{{ $dot->trang_thai }}">{{ $labels[$dot->trang_thai] ?? '' }}</span>
                    <a href="{{ route('tuyen-sinh.show', $dot->id) }}" class="btn-xem">Xem chỉ tiêu <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            @empty
            <div class="text-center py-5 text-muted">Chưa có đợt tuyển sinh nào.</div>
            @endforelse
        </div>

       {{-- Phương thức xét tuyển --}}
        <h2 class="section-title mt-5"><i class="fas fa-list-alt"></i> Phương Thức Xét Tuyển</h2>
        <div class="pt-grid">
            @foreach($phuongThucs as $pt)
            <div class="pt-card">
                <div class="pt-ma">{{ $pt->ma_phuong_thuc }}</div>
                <div class="pt-ten">{{ $pt->ten_phuong_thuc }}</div>
                @if($pt->mo_ta)
                    <div class="pt-mo-ta">{{ $pt->mo_ta }}</div>
                @endif
                <div class="pt-dieu-kien">
                    <i class="fas fa-tag" style="color:var(--navy);margin-right:5px"></i>
                    {{ $pt->loai_diem == 'hoc_ba' ? 'Xét học bạ' : ($pt->loai_diem == 'thi_thpt' ? 'Thi THPT Quốc gia' : 'Đánh giá năng lực') }}
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection