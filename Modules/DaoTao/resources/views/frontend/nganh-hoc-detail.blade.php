@extends('layouts.app')

@section('title', $nganhHoc->ten_nganh . ' — STU Tuyển Sinh 2026')

@section('content')
<style>
    .detail-hero { background: linear-gradient(135deg, var(--navy) 0%, var(--blue) 100%); padding: 56px 0; color: white; }
    .detail-hero .badge-khoa { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,.15); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 12px; }
    .detail-hero h1 { font-family: var(--font-display); font-size: clamp(26px,4vw,40px); margin-bottom: 8px; }
    .detail-hero .en { font-size: 15px; opacity: .7; margin-bottom: 20px; }
    .detail-meta { display: flex; flex-wrap: wrap; gap: 20px; }
    .detail-meta-item { display: flex; align-items: center; gap: 8px; font-size: 13.5px; }
    .detail-meta-item i { color: var(--gold); }
    .detail-body { padding: 48px 0; }
    .detail-grid { display: grid; grid-template-columns: 1fr 340px; gap: 32px; align-items: start; }
    .detail-card { background: white; border: 1px solid var(--gray-100); border-radius: var(--radius-lg); padding: 24px; margin-bottom: 24px; }
    .detail-card h3 { font-size: 16px; font-weight: 700; color: var(--navy); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
    .detail-card h3 i { color: var(--red); }
    .tohop-list { display: flex; flex-wrap: wrap; gap: 8px; }
    .tohop-item { display: flex; flex-direction: column; align-items: center; padding: 10px 16px; border-radius: 10px; border: 1.5px solid var(--gray-200); }
    .tohop-item.chinh { background: var(--navy); color: white; border-color: var(--navy); }
    .tohop-item .ma { font-size: 16px; font-weight: 800; }
    .tohop-item .ten { font-size: 11px; opacity: .7; margin-top: 2px; }
    .hocphi-table { width: 100%; border-collapse: collapse; }
    .hocphi-table th { background: var(--gray-50); padding: 10px 14px; text-align: left; font-size: 13px; color: var(--gray-700); border-bottom: 2px solid var(--gray-100); }
    .hocphi-table td { padding: 10px 14px; font-size: 13.5px; border-bottom: 1px solid var(--gray-100); }
    .hocphi-table tr:last-child td { border-bottom: none; }
    .ctdt-item { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--gray-100); }
    .ctdt-item:last-child { border-bottom: none; }
    .ctdt-info { display: flex; align-items: center; gap: 10px; }
    .ctdt-info i { color: var(--red); font-size: 20px; }
    .ctdt-name { font-size: 13.5px; font-weight: 600; color: var(--navy); }
    .ctdt-meta { font-size: 12px; color: var(--gray-500); }
    .btn-download { padding: 6px 14px; background: var(--red); color: white; border-radius: 50px; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 6px; transition: all .2s; }
    .btn-download:hover { background: var(--red-dark); }
    .sidebar-card { background: white; border: 1px solid var(--gray-100); border-radius: var(--radius-lg); padding: 20px; margin-bottom: 20px; }
    .sidebar-card h4 { font-size: 14px; font-weight: 700; color: var(--navy); margin-bottom: 14px; }
    .info-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid var(--gray-100); font-size: 13px; }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: var(--gray-500); }
    .info-value { font-weight: 700; color: var(--navy); }
    .btn-dangky { display: block; text-align: center; padding: 12px; background: var(--red); color: white; border-radius: var(--radius-md); font-weight: 700; font-size: 14px; transition: all .2s; margin-top: 16px; }
    .btn-dangky:hover { background: var(--red-dark); transform: translateY(-2px); }
    .breadcrumb-bar { background: var(--gray-50); border-bottom: 1px solid var(--gray-100); padding: 10px 0; }
    .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--gray-500); list-style: none; }
    .breadcrumb a { color: var(--navy); font-weight: 500; }
    .breadcrumb a:hover { color: var(--red); }
    .breadcrumb i { font-size: 10px; }
</style>

{{-- Breadcrumb --}}
<div class="breadcrumb-bar">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}">Trang chủ</a></li>
            <li><i class="fas fa-chevron-right"></i></li>
            <li><a href="{{ url('/nganh-hoc') }}">Ngành học</a></li>
            <li><i class="fas fa-chevron-right"></i></li>
            <li>{{ $nganhHoc->ten_nganh }}</li>
        </ul>
    </div>
</div>

{{-- Hero --}}
<div class="detail-hero">
    <div class="container">
        <div class="badge-khoa">
            <i class="fas fa-university"></i>
            {{ $nganhHoc->khoa->ten_khoa ?? '' }}
        </div>
        <h1>{{ $nganhHoc->ten_nganh }}</h1>
        @if($nganhHoc->ten_nganh_en)
            <div class="en">{{ $nganhHoc->ten_nganh_en }}</div>
        @endif
        <div class="detail-meta">
            <div class="detail-meta-item"><i class="fas fa-hashtag"></i> Mã ngành: {{ $nganhHoc->ma_nganh }}</div>
            <div class="detail-meta-item"><i class="fas fa-clock"></i> {{ $nganhHoc->thoi_gian_dao_tao }} năm</div>
            <div class="detail-meta-item"><i class="fas fa-graduation-cap"></i> {{ $nganhHoc->trinh_do == 'dai_hoc' ? 'Đại học' : 'Liên thông' }}</div>
            @if($nganhHoc->hocPhi->first())
            <div class="detail-meta-item"><i class="fas fa-money-bill"></i> {{ number_format($nganhHoc->hocPhi->first()->hoc_phi_mot_hk) }}đ/học kỳ</div>
            @endif
        </div>
    </div>
</div>

{{-- Body --}}
<div class="detail-body">
    <div class="container">
        <div class="detail-grid">

            {{-- Main --}}
            <div>
                {{-- Mô tả --}}
                @if($nganhHoc->mo_ta)
                <div class="detail-card">
                    <h3><i class="fas fa-info-circle"></i> Giới thiệu ngành</h3>
                    <p style="font-size:14px;line-height:1.8;color:var(--gray-700)">{{ $nganhHoc->mo_ta }}</p>
                </div>
                @endif

                {{-- Chuẩn đầu ra --}}
                @if($nganhHoc->chuan_dau_ra)
                <div class="detail-card">
                    <h3><i class="fas fa-check-circle"></i> Chuẩn đầu ra</h3>
                    <p style="font-size:14px;line-height:1.8;color:var(--gray-700)">{{ $nganhHoc->chuan_dau_ra }}</p>
                </div>
                @endif

                {{-- Tổ hợp môn --}}
                @if($nganhHoc->toHopMon->count())
                <div class="detail-card">
                    <h3><i class="fas fa-layer-group"></i> Tổ hợp môn xét tuyển</h3>
                    <div class="tohop-list">
                        @foreach($nganhHoc->toHopMon as $tohop)
                        <div class="tohop-item {{ $tohop->is_chinh ? 'chinh' : '' }}">
                            <span class="ma">{{ $tohop->ma_to_hop }}</span>
                            <span class="ten">{{ $tohop->ten_to_hop }}</span>
                            @if($tohop->is_chinh)
                                <span style="font-size:10px;margin-top:3px;opacity:.8">Tổ hợp chính</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Học phí --}}
                @if($nganhHoc->hocPhi->count())
                <div class="detail-card">
                    <h3><i class="fas fa-money-bill-wave"></i> Học phí</h3>
                    <table class="hocphi-table">
                        <thead>
                            <tr>
                                <th>Năm học</th>
                                <th>Học phí/Học kỳ</th>
                                <th>Học phí/Tín chỉ</th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nganhHoc->hocPhi as $hp)
                            <tr>
                                <td><strong>{{ $hp->nam_hoc }}</strong></td>
                                <td style="color:var(--red);font-weight:700">{{ number_format($hp->hoc_phi_mot_hk) }}đ</td>
                                <td>{{ number_format($hp->hoc_phi_tin_chi) }}đ</td>
                                <td style="color:var(--gray-500)">{{ $hp->ghi_chu ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                {{-- CTDT --}}
                @if($nganhHoc->chuongTrinhDaoTao->where('is_hien_thi', 1)->count())
                <div class="detail-card">
                    <h3><i class="fas fa-file-pdf"></i> Chương trình đào tạo</h3>
                    @foreach($nganhHoc->chuongTrinhDaoTao->where('is_hien_thi', 1) as $ctdt)
                    <div class="ctdt-item">
                        <div class="ctdt-info">
                            <i class="fas fa-file-pdf"></i>
                            <div>
                                <div class="ctdt-name">CTĐT năm {{ $ctdt->nam_ban_hanh }}</div>
                                <div class="ctdt-meta">{{ $ctdt->tong_tin_chi }} tín chỉ · {{ $ctdt->ten_file }}</div>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $ctdt->duong_dan_file) }}" target="_blank" class="btn-download">
                            <i class="fas fa-download"></i> Tải về
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div>
                <div class="sidebar-card">
                    <h4>Thông tin tuyển sinh</h4>
                    <div class="info-row">
                        <span class="info-label">Mã ngành</span>
                        <span class="info-value">{{ $nganhHoc->ma_nganh }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Khoa</span>
                        <span class="info-value">{{ $nganhHoc->khoa->ma_khoa ?? '—' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Trình độ</span>
                        <span class="info-value">{{ $nganhHoc->trinh_do == 'dai_hoc' ? 'Đại học' : 'Liên thông' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Thời gian</span>
                        <span class="info-value">{{ $nganhHoc->thoi_gian_dao_tao }} năm</span>
                    </div>
                    @if($nganhHoc->hocPhi->first())
                    <div class="info-row">
                        <span class="info-label">Học phí/HK</span>
                        <span class="info-value" style="color:var(--red)">{{ number_format($nganhHoc->hocPhi->first()->hoc_phi_mot_hk) }}đ</span>
                    </div>
                    @endif
                    <a href="{{ url('/ho-so/dang-ky') }}" class="btn-dangky">
                        <i class="fas fa-edit"></i> Đăng ký xét tuyển
                    </a>
                </div>

                <div class="sidebar-card">
                    <h4>Tư vấn ngành học</h4>
                    <p style="font-size:13px;color:var(--gray-500);margin-bottom:14px;line-height:1.6">Bạn cần tư vấn thêm về ngành học này? Liên hệ với chúng tôi!</p>
                    <a href="{{ url('/tu-van') }}" class="btn-dangky" style="background:var(--navy)">
                        <i class="fas fa-comments"></i> Gửi câu hỏi
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection