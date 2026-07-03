@extends('layouts.app')
@section('title', 'Tuyển Sinh — STU 2026')
@section('content')
<style>
    .page-hero { background: linear-gradient(135deg, var(--navy) 0%, var(--blue) 100%); padding: 56px 0 0; color: white; position: relative; overflow: hidden; }
    .page-hero::after { content: ''; position: absolute; right: -60px; top: -60px; width: 260px; height: 260px; border-radius: 50%; background: rgba(255,255,255,.06); }
    .page-hero h1 { font-family: var(--font-display); font-size: clamp(28px,4vw,42px); margin-bottom: 12px; }
    .page-hero p { font-size: 15px; opacity: .8; max-width: 560px; }
    .hero-stats { display: flex; gap: 0; margin-top: 40px; border-top: 1px solid rgba(255,255,255,.15); }
    .hero-stat { flex: 1; padding: 20px 0 24px; border-right: 1px solid rgba(255,255,255,.15); }
    .hero-stat:last-child { border-right: none; }
    .hero-stat .num { font-family: var(--font-display); font-size: 30px; font-weight: 800; color: var(--gold); line-height: 1; }
    .hero-stat .label { font-size: 12px; opacity: .75; margin-top: 6px; letter-spacing: .03em; }

    .ts-section { padding: 48px 0; }
    .section-title { font-family: var(--font-display); font-size: 22px; color: var(--navy); margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid var(--gray-100); display: flex; align-items: center; gap: 10px; }

    .dot-list { display: flex; flex-direction: column; gap: 16px; }
    .dot-card { background: white; border: 1px solid var(--gray-100); border-radius: var(--radius-lg); padding: 22px 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; transition: all .25s; position: relative; }
    .dot-card:hover { box-shadow: var(--shadow-hover); border-color: var(--gray-300); transform: translateY(-2px); }
    .dot-card.la-dang-mo { border-left: 4px solid #2e9e5b; }
    .dot-info { flex: 1; min-width: 0; }
    .dot-ma { font-size: 11px; font-weight: 700; color: var(--gray-500); letter-spacing: .08em; margin-bottom: 4px; }
    .dot-ten { font-family: var(--font-display); font-size: 17px; color: var(--navy); margin-bottom: 8px; }
    .dot-meta { display: flex; flex-wrap: wrap; gap: 14px; }
    .dot-meta-item { font-size: 12.5px; color: var(--gray-500); display: flex; align-items: center; gap: 5px; }
    .dot-meta-item i { color: var(--navy); width: 14px; }
    .dot-badge { padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; white-space: nowrap; }
    .badge-dang_mo { background: #d4edda; color: #155724; }
    .badge-da_cong_bo { background: #cce5ff; color: #004085; }
    .badge-da_dong { background: #f8d7da; color: #721c24; }
    .badge-chuan_bi { background: #e2e3e5; color: #383d41; }
    .countdown { display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 700; color: #b8860b; background: #fff8e1; padding: 3px 10px; border-radius: 20px; margin-top: 6px; }
    .countdown i { font-size: 10px; }
    .dot-right { display: flex; flex-direction: column; align-items: flex-end; gap: 10px; flex-shrink: 0; }
    .dot-right-top { display: flex; align-items: center; gap: 12px; }
    .dot-chitieu { font-size: 12px; color: var(--gray-500); text-align: right; }
    .dot-chitieu strong { color: var(--navy); font-size: 15px; }
    .btn-xem { padding: 8px 20px; background: var(--navy); color: white; border-radius: 50px; font-size: 13px; font-weight: 600; transition: all .2s; white-space: nowrap; }
    .btn-xem:hover { background: var(--red); }

    .pt-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
    .pt-card { background: white; border: 1px solid var(--gray-100); border-radius: var(--radius-lg); padding: 24px; transition: all .25s; display: flex; gap: 16px; }
    .pt-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-hover); }
    .pt-icon { width: 44px; height: 44px; border-radius: 12px; background: var(--gray-50); display: flex; align-items: center; justify-content: center; font-size: 18px; color: var(--navy); flex-shrink: 0; }
    .pt-body { min-width: 0; }
    .pt-ma { display: inline-block; background: var(--navy); color: white; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; margin-bottom: 8px; }
    .pt-ten { font-family: var(--font-display); font-size: 15.5px; color: var(--navy); margin-bottom: 6px; line-height: 1.35; }
    .pt-mo-ta { font-size: 12.5px; color: var(--gray-500); line-height: 1.6; }

    .empty-state { text-align: center; padding: 48px 20px; color: var(--gray-500); }
    .empty-state i { font-size: 32px; color: var(--gray-300); margin-bottom: 12px; display: block; }

    @media (max-width: 600px) {
        .dot-card { flex-direction: column; align-items: stretch; }
        .dot-right { align-items: stretch; }
        .dot-right-top { justify-content: space-between; }
    }
</style>

<div class="page-hero">
    <div class="container">
        <div class="section-label">Tuyển sinh</div>
        <h1>Thông tin Tuyển Sinh STU</h1>
        <p>Tìm hiểu các đợt tuyển sinh và phương thức xét tuyển tại Đại học Công nghệ Sài Gòn.</p>

        <div class="hero-stats">
            <div class="hero-stat">
                <div class="num">{{ $soDotDangMo }}</div>
                <div class="label">ĐỢT ĐANG MỞ</div>
            </div>
            <div class="hero-stat">
                <div class="num">{{ number_format($tongChiTieu) }}</div>
                <div class="label">CHỈ TIÊU ĐANG XÉT</div>
            </div>
            <div class="hero-stat">
                <div class="num">{{ $phuongThucs->count() }}</div>
                <div class="label">PHƯƠNG THỨC XÉT TUYỂN</div>
            </div>
        </div>
    </div>
</div>

<div class="ts-section">
    <div class="container">

        {{-- Đợt tuyển sinh --}}
        <h2 class="section-title"><i class="fas fa-calendar-alt"></i> Các Đợt Tuyển Sinh</h2>
        <div class="dot-list">
            @forelse($dots as $dot)
            @php
                $conHan = $dot->trang_thai === 'dang_mo' ? now()->diffInDays(\Carbon\Carbon::parse($dot->ngay_ket_thuc), false) : null;
                $labels = ['chuan_bi'=>'Chuẩn bị','dang_mo'=>'Đang mở','da_dong'=>'Đã đóng','da_cong_bo'=>'Đã công bố'];
            @endphp
            <div class="dot-card {{ $dot->trang_thai === 'dang_mo' ? 'la-dang-mo' : '' }}">
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
                    @if($conHan !== null && $conHan >= 0)
                        <div class="countdown"><i class="fas fa-clock"></i> Còn {{ $conHan }} ngày nhận hồ sơ</div>
                    @endif
                </div>
                <div class="dot-right">
                    <div class="dot-right-top">
                        <span class="dot-badge badge-{{ $dot->trang_thai_thuc_te }}">{{ $labels[$dot->trang_thai_thuc_te] ?? '' }}</span>
                    </div>
                    @if($dot->chi_tieu_sum_chi_tieu_giao)
                    <div class="dot-chitieu"><strong>{{ number_format($dot->chi_tieu_sum_chi_tieu_giao) }}</strong> chỉ tiêu</div>
                    @endif
                    <a href="{{ route('tuyen-sinh.show', $dot->id) }}" class="btn-xem">Xem chỉ tiêu <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                Hiện chưa có đợt tuyển sinh nào được công bố. Vui lòng quay lại sau.
            </div>
            @endforelse
        </div>

        {{-- Phương thức xét tuyển --}}
        <h2 class="section-title mt-5"><i class="fas fa-list-alt"></i> Phương Thức Xét Tuyển</h2>
        <div class="pt-grid">
            @forelse($phuongThucs as $pt)
            @php
                $icon = match($pt->loai_diem) {
                    'hoc_ba' => 'fa-book-open',
                    'thi_thpt' => 'fa-file-signature',
                    'danh_gia_nang_luc' => 'fa-brain',
                    default => 'fa-star',
                };
                $nhan = match($pt->loai_diem) {
                    'hoc_ba' => 'Xét học bạ',
                    'thi_thpt' => 'Thi THPT Quốc gia',
                    'danh_gia_nang_luc' => 'Đánh giá năng lực',
                    default => $pt->loai_diem,
                };
            @endphp
            <div class="pt-card">
                <div class="pt-icon"><i class="fas {{ $icon }}"></i></div>
                <div class="pt-body">
                    <div class="pt-ma">{{ $pt->ma_phuong_thuc }} · {{ $nhan }}</div>
                    <div class="pt-ten">{{ $pt->ten_phuong_thuc }}</div>
                    @if($pt->mo_ta)
                        <div class="pt-mo-ta">{{ Str::limit($pt->mo_ta, 90) }}</div>
                    @endif
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-list-alt"></i>
                Chưa có phương thức xét tuyển nào được công bố.
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection