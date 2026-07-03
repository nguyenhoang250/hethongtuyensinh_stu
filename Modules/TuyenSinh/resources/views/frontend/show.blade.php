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

    .hero-progress { margin-top: 24px; max-width: 420px; }
    .hero-progress-label { display: flex; justify-content: space-between; font-size: 12.5px; opacity: .85; margin-bottom: 6px; }
    .hero-progress-bar { height: 8px; background: rgba(255,255,255,.2); border-radius: 20px; overflow: hidden; }
    .hero-progress-fill { height: 100%; background: var(--gold); border-radius: 20px; }

    .ct-section { padding: 48px 0; }
    .breadcrumb-bar { background: var(--gray-50); border-bottom: 1px solid var(--gray-100); padding: 10px 0; }
    .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--gray-500); list-style: none; }
    .breadcrumb a { color: var(--navy); font-weight: 500; }
    .breadcrumb i { font-size: 10px; }

    .search-box { position: relative; margin-bottom: 28px; }
    .search-box input { width: 100%; padding: 12px 16px 12px 42px; border: 1px solid var(--gray-200); border-radius: var(--radius-md); font-size: 14px; }
    .search-box input:focus { outline: none; border-color: var(--navy); }
    .search-box i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--gray-400); }

    .khoa-group { margin-bottom: 32px; }
    .khoa-title { font-family: var(--font-display); font-size: 16px; color: var(--navy); margin-bottom: 12px; padding-bottom: 8px; border-bottom: 2px solid var(--gray-100); display: flex; align-items: center; gap: 8px; }
    .khoa-title i { color: var(--red); font-size: 14px; }

    .nganh-card { background: white; border: 1px solid var(--gray-100); border-radius: var(--radius-lg); padding: 18px 20px; margin-bottom: 12px; }
    .nganh-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap; }
    .nganh-ten { font-family: var(--font-display); font-size: 15px; color: var(--navy); }
    .nganh-ten a { color: inherit; }
    .nganh-ma { font-size: 11px; color: var(--gray-500); margin-top: 2px; }
    .nganh-scores { display: flex; gap: 20px; text-align: right; flex-shrink: 0; }
    .score-block .val { font-family: var(--font-display); font-size: 18px; font-weight: 800; color: var(--navy); }
    .score-block .val.has-diem { color: var(--red); }
    .score-block .lbl { font-size: 10.5px; color: var(--gray-500); text-transform: uppercase; letter-spacing: .03em; }

    .nganh-bottom { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-top: 14px; flex-wrap: wrap; }
    .pt-tag { display: inline-flex; align-items: center; gap: 5px; background: var(--gray-50); color: var(--navy); font-size: 11.5px; font-weight: 600; padding: 4px 10px; border-radius: 20px; }
    .progress-wrap { display: flex; align-items: center; gap: 8px; min-width: 160px; }
    .progress-track { flex: 1; height: 6px; background: var(--gray-100); border-radius: 20px; overflow: hidden; }
    .progress-fill { height: 100%; background: var(--navy); border-radius: 20px; }
    .progress-txt { font-size: 11px; color: var(--gray-500); white-space: nowrap; }

    .btn-dangky { display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; background: var(--red); color: white; border-radius: 50px; font-weight: 700; font-size: 14px; transition: all .2s; margin-top: 8px; }
    .btn-dangky:hover { background: var(--red-dark); transform: translateY(-2px); }

    .empty-state { text-align: center; padding: 48px 20px; color: var(--gray-500); }
    .empty-state i { font-size: 32px; color: var(--gray-300); margin-bottom: 12px; display: block; }
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
        @php
            $labels = ['chuan_bi'=>'Chuẩn bị','dang_mo'=>'Đang mở','da_dong'=>'Đã đóng','da_cong_bo'=>'Đã công bố'];
            $tiLe = $tongChiTieu > 0 ? round(($tongDaTuyen / $tongChiTieu) * 100) : 0;
        @endphp
        <span class="dot-badge badge-{{ $dot->trang_thai }}">{{ $labels[$dot->trang_thai] ?? '' }}</span>
        <h1 class="mt-2">{{ $dot->ten_dot }}</h1>
        <div class="hero-meta">
            <div class="hero-meta-item"><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($dot->ngay_bat_dau)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($dot->ngay_ket_thuc)->format('d/m/Y') }}</div>
            <div class="hero-meta-item"><i class="fas fa-graduation-cap"></i> Năm học {{ $dot->nam_hoc }}</div>
            @if($dot->ngay_cong_bo)
            <div class="hero-meta-item"><i class="fas fa-bullhorn"></i> Công bố KQ: {{ \Carbon\Carbon::parse($dot->ngay_cong_bo)->format('d/m/Y') }}</div>
            @endif
        </div>

        @if($tongChiTieu > 0)
        <div class="hero-progress">
            <div class="hero-progress-label">
                <span>Đã tuyển {{ number_format($tongDaTuyen) }} / {{ number_format($tongChiTieu) }} chỉ tiêu</span>
                <span>{{ $tiLe }}%</span>
            </div>
            <div class="hero-progress-bar">
                <div class="hero-progress-fill" style="width: {{ min($tiLe, 100) }}%"></div>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="ct-section">
    <div class="container">
        @if($dot->ghi_chu)
        <div class="alert alert-info mb-4"><i class="fas fa-info-circle"></i> {{ $dot->ghi_chu }}</div>
        @endif

        @if($chiTieus->isNotEmpty())
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="timNganh" placeholder="Tìm theo tên ngành...">
        </div>

        @foreach($chiTieus as $tenKhoa => $dsChiTieu)
        <div class="khoa-group">
            <div class="khoa-title"><i class="fas fa-building"></i> {{ $tenKhoa }}</div>

            @foreach($dsChiTieu as $ct)
            @php
                $tiLeNganh = $ct->chi_tieu_giao > 0 ? round(($ct->chi_tieu_da_tuyen / $ct->chi_tieu_giao) * 100) : 0;
            @endphp
            <div class="nganh-card" data-ten-nganh="{{ Str::lower($ct->nganhHoc->ten_nganh ?? '') }}">
                <div class="nganh-top">
                    <div>
                        <div class="nganh-ten">
                            <a href="{{ url('/nganh-hoc/' . $ct->nganh_hoc_id) }}">{{ $ct->nganhHoc->ten_nganh ?? '—' }}</a>
                        </div>
                        <div class="nganh-ma">{{ $ct->nganhHoc->ma_nganh ?? '' }}</div>
                    </div>
                    <div class="nganh-scores">
                        <div class="score-block">
                            <div class="val {{ $ct->diem_chuan ? 'has-diem' : '' }}">{{ $ct->diem_chuan ?? '—' }}</div>
                            <div class="lbl">Điểm chuẩn</div>
                        </div>
                        <div class="score-block">
                            <div class="val">{{ $ct->diem_san_nop_hs ?? '—' }}</div>
                            <div class="lbl">Điểm sàn</div>
                        </div>
                    </div>
                </div>
                <div class="nganh-bottom">
                    <span class="pt-tag"><i class="fas fa-tag"></i> {{ $ct->phuongThuc->ma_phuong_thuc ?? '—' }} — {{ $ct->phuongThuc->ten_phuong_thuc ?? '' }}</span>
                    <div class="progress-wrap">
                        <div class="progress-track"><div class="progress-fill" style="width: {{ min($tiLeNganh, 100) }}%"></div></div>
                        <span class="progress-txt">{{ $ct->chi_tieu_da_tuyen }}/{{ $ct->chi_tieu_giao }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
        @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            Chưa có chỉ tiêu nào được công bố cho đợt này.
        </div>
        @endif

        <a href="{{ url('/ho-so/dang-ky') }}" class="btn-dangky">
            <i class="fas fa-edit"></i> Đăng ký xét tuyển ngay
        </a>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('timNganh')?.addEventListener('input', function (e) {
        const tu = e.target.value.trim().toLowerCase();
        document.querySelectorAll('.nganh-card').forEach(card => {
            card.style.display = card.dataset.tenNganh.includes(tu) ? '' : 'none';
        });
        document.querySelectorAll('.khoa-group').forEach(group => {
            const conHien = [...group.querySelectorAll('.nganh-card')].some(c => c.style.display !== 'none');
            group.style.display = conHien ? '' : 'none';
        });
    });
</script>
@endpush
@endsection