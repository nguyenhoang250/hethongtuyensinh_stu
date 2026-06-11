@extends('layouts.app')

@section('title', 'Tuyển Sinh 2026 — Đại học Công nghệ Sài Gòn (STU)')

@section('styles')
<style>
    /* ===== HERO SLIDER ===== */
    .hero { position: relative; height: 560px; overflow: hidden; background: var(--navy); }
    .hero-slide { position: absolute; inset: 0; display: flex; align-items: center; opacity: 0; transition: opacity .8s ease; }
    .hero-slide.active { opacity: 1; }
    .hero-slide .bg { position: absolute; inset: 0; background-size: cover; background-position: center; }
    .hero-slide .bg::after { content: ''; position: absolute; inset: 0; background: linear-gradient(105deg, rgba(11,31,77,.92) 35%, rgba(166,30,34,.55) 100%); }
    .hero-content { position: relative; z-index: 2; max-width: 1240px; margin: 0 auto; padding: 0 24px; width: 100%; }
    .hero-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(232,160,32,.18); border: 1px solid rgba(232,160,32,.4); color: var(--gold-light); padding: 5px 14px; border-radius: 50px; font-size: 12px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; margin-bottom: 20px; }
    .hero-badge .dot { width: 6px; height: 6px; background: var(--gold); border-radius: 50%; animation: blink 1.5s infinite; }
    @@keyframes blink { 0%,100%{opacity:1}50%{opacity:.3} }
    .hero h1 { font-family: var(--font-display); font-size: clamp(36px, 5vw, 58px); color: white; line-height: 1.15; margin-bottom: 18px; max-width: 640px; }
    .hero h1 .accent { color: var(--gold-light); }
    .hero p { color: rgba(255,255,255,.78); font-size: 16px; line-height: 1.7; max-width: 500px; margin-bottom: 32px; }
    .hero-ctas { display: flex; gap: 12px; flex-wrap: wrap; }
    .hero-cta-primary { padding: 13px 28px; background: var(--red); color: white; border-radius: 50px; font-weight: 700; font-size: 15px; display: inline-flex; align-items: center; gap: 8px; transition: all .25s; box-shadow: 0 6px 24px rgba(200,16,46,.45); }
    .hero-cta-primary:hover { background: var(--red-light); transform: translateY(-2px); }
    .hero-cta-secondary { padding: 13px 28px; border: 1.5px solid rgba(255,255,255,.5); color: white; border-radius: 50px; font-weight: 600; font-size: 15px; display: inline-flex; align-items: center; gap: 8px; transition: all .25s; backdrop-filter: blur(4px); }
    .hero-cta-secondary:hover { background: rgba(255,255,255,.12); border-color: white; }
    .hero-dots { position: absolute; bottom: 28px; left: 50%; transform: translateX(-50%); display: flex; gap: 8px; z-index: 10; }
    .hero-dot { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,.4); cursor: pointer; transition: all .3s; }
    .hero-dot.active { background: var(--gold); width: 24px; border-radius: 4px; }

    /* ===== STATS BAR ===== */
    .stats-bar { background: var(--navy); color: white; }
    .stats-bar .inner { max-width: 1240px; margin: 0 auto; padding: 0 24px; display: grid; grid-template-columns: repeat(4, 1fr); }
    .stat-item { padding: 24px 20px; text-align: center; border-right: 1px solid rgba(255,255,255,.08); }
    .stat-item:last-child { border-right: none; }
    .stat-num { font-family: var(--font-display); font-size: 36px; font-weight: 700; color: var(--gold-light); line-height: 1; }
    .stat-label { font-size: 12.5px; color: rgba(255,255,255,.6); margin-top: 6px; font-weight: 500; }

    /* ===== PHUONG THUC XET TUYEN ===== */
    .method-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; }
    .method-card { background: white; border: 1.5px solid var(--gray-100); border-radius: var(--radius-lg); padding: 28px 24px; transition: all .3s; position: relative; overflow: hidden; cursor: pointer; }
    .method-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: var(--red); transform: scaleX(0); transform-origin: left; transition: transform .3s; }
    .method-card:hover { border-color: var(--red); box-shadow: var(--shadow-hover); transform: translateY(-2px); }
    .method-card:hover::before { transform: scaleX(1); }
    .method-icon { width: 52px; height: 52px; background: rgba(200,16,46,.08); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; color: var(--red); font-size: 22px; margin-bottom: 16px; }
    .method-code { display: inline-block; background: var(--navy); color: white; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 4px; letter-spacing: .05em; margin-bottom: 8px; }
    .method-name { font-weight: 700; font-size: 15px; color: var(--navy); margin-bottom: 6px; }
    .method-desc { font-size: 13px; color: var(--gray-500); line-height: 1.6; }

    /* ===== NGANH HOC ===== */
    .nganh-tabs { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 28px; }
    .nganh-tab { padding: 7px 18px; border-radius: 50px; font-size: 13px; font-weight: 600; border: 1.5px solid var(--gray-300); color: var(--gray-500); cursor: pointer; transition: all .2s; background: white; }
    .nganh-tab.on { background: linear-gradient(135deg, var(--red), var(--red-light)); color: white; border-color: var(--red); }
    .nganh-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px; }
    .nganh-card { background: white; border: 1px solid var(--gray-100); border-radius: var(--radius-md); padding: 20px; display: flex; align-items: flex-start; gap: 14px; transition: all .25s; text-decoration: none; }
    .nganh-card:hover { border-color: var(--red); box-shadow: var(--shadow-card); }
    .nganh-card[style*="display:none"] { display: none !important; }
    .nganh-icon { width: 44px; height: 44px; border-radius: 10px; background: var(--gray-50); display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
    .nganh-info { flex: 1; min-width: 0; }
    .nganh-name { font-weight: 700; font-size: 14px; color: var(--navy); line-height: 1.4; margin-bottom: 4px; }
    .nganh-meta { font-size: 12px; color: var(--gray-500); display: flex; align-items: center; gap: 10px; }
    .nganh-meta span { display: flex; align-items: center; gap: 4px; }
    .nganh-score { font-size: 11px; font-weight: 700; background: rgba(200,16,46,.08); color: var(--red); padding: 2px 8px; border-radius: 4px; margin-top: 6px; display: inline-block; }

    /* ===== TIN TUC ===== */
    .news-featured { border-radius: var(--radius-lg); overflow: hidden; background: white; box-shadow: var(--shadow-card); transition: box-shadow .3s; text-decoration: none; display: block; }
    .news-featured:hover { box-shadow: var(--shadow-hover); }
    .news-featured .img-wrap { height: 220px; overflow: hidden; }
    .news-featured .img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
    .news-featured:hover .img-wrap img { transform: scale(1.04); }
    .news-featured .body { padding: 22px; }
    .news-tag { display: inline-block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--red); margin-bottom: 8px; }
    .news-title { font-weight: 700; font-size: 15.5px; color: var(--navy); line-height: 1.45; margin-bottom: 8px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .news-date { font-size: 12px; color: var(--gray-500); display: flex; align-items: center; gap: 6px; }
    .news-item { background: white; border-radius: var(--radius-md); overflow: hidden; display: flex; gap: 14px; padding: 14px; box-shadow: var(--shadow-card); transition: box-shadow .3s; text-decoration: none; }
    .news-item:hover { box-shadow: var(--shadow-hover); }
    .news-item .thumb { width: 80px; height: 68px; border-radius: 8px; overflow: hidden; flex-shrink: 0; }
    .news-item .thumb img { width: 100%; height: 100%; object-fit: cover; }
    .news-item .info { flex: 1; }
    .news-item .news-title { font-size: 13.5px; -webkit-line-clamp: 3; }

    /* ===== SU KIEN ===== */
    .sukien-list { display: flex; flex-direction: column; gap: 14px; }
    .sukien-item { background: white; border-radius: var(--radius-md); padding: 18px 20px; display: flex; align-items: center; gap: 18px; border: 1px solid var(--gray-100); box-shadow: var(--shadow-card); transition: all .25s; text-decoration: none; }
    .sukien-item:hover { border-color: var(--red); transform: translateX(4px); }
    .sukien-date { text-align: center; flex-shrink: 0; width: 52px; }
    .sukien-date .day { font-family: var(--font-display); font-size: 28px; font-weight: 700; color: var(--red); line-height: 1; }
    .sukien-date .month { font-size: 12px; font-weight: 600; color: var(--gray-500); text-transform: uppercase; }
    .sukien-divider { width: 1px; height: 48px; background: var(--gray-100); flex-shrink: 0; }
    .sukien-info { flex: 1; }
    .sukien-title { font-weight: 700; font-size: 14.5px; color: var(--navy); margin-bottom: 4px; }
    .sukien-meta { font-size: 12.5px; color: var(--gray-500); display: flex; align-items: center; gap: 14px; }
    .sukien-tag { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; padding: 3px 10px; border-radius: 4px; }
    .sukien-tag.tuvan { background: rgba(200,16,46,.1); color: var(--red); }
    .sukien-tag.hocbong { background: rgba(232,160,32,.12); color: #9B6A00; }
    .sukien-tag.nganhhoc { background: rgba(13,27,62,.08); color: var(--navy); }
    .sukien-arrow { color: var(--gray-300); font-size: 16px; flex-shrink: 0; transition: color .2s; }
    .sukien-item:hover .sukien-arrow { color: var(--red); }

    /* ===== HOC BONG ===== */
    .hocbong-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
    .hocbong-card { border-radius: var(--radius-lg); overflow: hidden; position: relative; background: var(--navy); color: white; padding: 32px 28px; min-height: 200px; display: flex; flex-direction: column; justify-content: flex-end; text-decoration: none; }
    .hocbong-card .bg-deco { position: absolute; top: -20px; right: -20px; width: 140px; height: 140px; border-radius: 50%; background: rgba(255,255,255,.05); pointer-events: none; }
    .hocbong-card .bg-deco2 { position: absolute; bottom: -40px; right: 20px; width: 100px; height: 100px; border-radius: 50%; background: rgba(255,255,255,.04); pointer-events: none; }
    .hocbong-card.red { background: linear-gradient(135deg, var(--red-dark), var(--red-light)); }
    .hocbong-card.gold { background: linear-gradient(135deg, #7A5000, #C47F17); }
    .hocbong-card.navy { background: linear-gradient(135deg, var(--navy), var(--navy-mid)); }
    .hocbong-percent { font-family: var(--font-display); font-size: 52px; font-weight: 700; line-height: 1; color: rgba(255,255,255,.15); position: absolute; top: 20px; right: 20px; }
    .hocbong-icon { font-size: 28px; margin-bottom: 14px; opacity: .85; }
    .hocbong-name { font-weight: 700; font-size: 17px; margin-bottom: 6px; }
    .hocbong-desc { font-size: 13px; color: rgba(255,255,255,.7); line-height: 1.5; margin-bottom: 14px; }
    .hocbong-value { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,.15); padding: 6px 14px; border-radius: 50px; font-weight: 700; font-size: 14px; }

    /* ===== ONG KINH ===== */
    .okgrid { display: grid; grid-template-columns: 1fr 320px; gap: 20px; align-items: start; }
    .ok-main-img { position: relative; border-radius: var(--radius-lg); overflow: hidden; height: 320px; }
    .ok-main-img img { width: 100%; height: 100%; object-fit: cover; }
    .ok-play { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,.25); }
    .ok-play i { width: 68px; height: 68px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--red); font-size: 24px; padding-left: 5px; box-shadow: 0 8px 32px rgba(0,0,0,.3); transition: transform .2s, box-shadow .2s; }
    .ok-play:hover i { transform: scale(1.1); box-shadow: 0 12px 40px rgba(0,0,0,.4); }
    .ok-thumbs { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 10px; }
    .ok-thumb { border-radius: var(--radius-md); overflow: hidden; height: 100px; }
    .ok-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s; }
    .ok-thumb:hover img { transform: scale(1.06); }
    .ok-side { display: flex; flex-direction: column; gap: 10px; }
    .ok-side-img { border-radius: var(--radius-md); overflow: hidden; height: 210px; }
    .ok-side-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s; }
    .ok-side-img:hover img { transform: scale(1.04); }

    /* ===== NCKH ===== */
    .nckh-wrap { position: relative; }
    .nckh-slider-track { position: relative; min-height: 360px; }
    .nckh-card { display: grid; grid-template-columns: 1fr 1fr; border-radius: var(--radius-lg); overflow: hidden; background: white; box-shadow: var(--shadow-card); opacity: 0; position: absolute; top: 0; left: 0; right: 0; transition: opacity .5s; pointer-events: none; }
    .nckh-card.nckh-active { opacity: 1; position: relative; pointer-events: all; }
    .nckh-img { height: 360px; overflow: hidden; }
    .nckh-img img { width: 100%; height: 100%; object-fit: cover; }
    .nckh-caption { padding: 40px 36px; display: flex; flex-direction: column; justify-content: center; background: white; }
    .nckh-date { font-size: 13px; color: var(--red); font-weight: 600; margin-bottom: 12px; display: block; }
    .nckh-title { font-family: var(--font-display); font-size: 22px; font-weight: 700; color: var(--navy); line-height: 1.4; margin-bottom: 14px; display: block; transition: color .2s; text-decoration: none; }
    .nckh-title:hover { color: var(--red); }
    .nckh-desc { font-size: 14px; color: var(--gray-500); line-height: 1.7; margin-bottom: 24px; }
    .nckh-controls { display: flex; gap: 10px; justify-content: center; margin-top: 24px; }
    .nckh-btn { width: 44px; height: 44px; border-radius: 50%; border: 2px solid var(--gray-100); background: white; color: var(--navy); font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all .2s; }
    .nckh-btn:hover { background: var(--red); border-color: var(--red); color: white; }
    .nckh-dots-row { display: flex; gap: 8px; justify-content: center; margin-top: 14px; }
    .nckh-dot-item { width: 8px; height: 8px; border-radius: 50%; background: var(--gray-300); cursor: pointer; transition: all .3s; }
    .nckh-dot-item.on { background: var(--red); width: 24px; border-radius: 4px; }

    /* ===== VI SAO CHON STU ===== */
    .visao-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; align-items: center; }
    .visao-img-wrap { position: relative; border-radius: var(--radius-lg); overflow: hidden; height: 420px; }
    .visao-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .visao-img-badge { position: absolute; bottom: 20px; left: 20px; background: white; color: var(--navy); font-weight: 700; font-size: 15px; padding: 10px 20px; border-radius: 50px; box-shadow: 0 4px 20px rgba(0,0,0,.15); }
    .visao-cards { display: flex; flex-direction: column; gap: 16px; }
    .visao-card { background: white; border: 1.5px solid var(--gray-100); border-radius: var(--radius-md); padding: 22px 20px; display: flex; align-items: center; justify-content: space-between; gap: 16px; transition: all .25s; text-decoration: none; }
    .visao-card:hover { border-color: var(--red); box-shadow: var(--shadow-hover); transform: translateX(4px); }
    .visao-card-left { display: flex; align-items: flex-start; gap: 16px; flex: 1; }
    .visao-icon { width: 48px; height: 48px; flex-shrink: 0; background: rgba(200,16,46,.08); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; color: var(--red); font-size: 20px; }
    .visao-title { font-weight: 700; font-size: 15px; color: var(--navy); margin-bottom: 5px; }
    .visao-desc { font-size: 13px; color: var(--gray-500); line-height: 1.6; }
    .visao-arrow { color: var(--gray-300); font-size: 14px; flex-shrink: 0; transition: color .2s, transform .2s; }
    .visao-card:hover .visao-arrow { color: var(--red); transform: translate(2px,-2px); }

    /* ===== FORM TU VAN ===== */
    .tuvan-wrap { background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%); border-radius: 24px; padding: 56px 48px; position: relative; overflow: hidden; }
    .tuvan-wrap::before { content: ''; position: absolute; top: -80px; right: -80px; width: 300px; height: 300px; border-radius: 50%; background: rgba(200,16,46,.12); pointer-events: none; }
    .tuvan-wrap::after { content: ''; position: absolute; bottom: -60px; left: 10%; width: 200px; height: 200px; border-radius: 50%; background: rgba(232,160,32,.07); pointer-events: none; }
    .tuvan-inner { display: grid; grid-template-columns: 1fr 1.2fr; gap: 56px; align-items: center; position: relative; z-index: 1; }
    .tuvan-left .label { font-size: 11px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--gold-light); margin-bottom: 12px; }
    .tuvan-left h2 { font-family: var(--font-display); font-size: clamp(24px, 3vw, 36px); color: white; line-height: 1.25; margin-bottom: 16px; }
    .tuvan-left p { color: rgba(255,255,255,.65); font-size: 15px; line-height: 1.7; margin-bottom: 24px; }
    .tuvan-contact { display: flex; flex-direction: column; gap: 10px; }
    .tuvan-contact a { display: flex; align-items: center; gap: 10px; color: rgba(255,255,255,.8); font-size: 14px; transition: color .2s; }
    .tuvan-contact a:hover { color: var(--gold-light); }
    .tuvan-contact i { color: var(--gold); font-size: 15px; width: 18px; }
    .tuvan-form { background: white; border-radius: var(--radius-lg); padding: 32px; }
    .tuvan-form h3 { font-weight: 700; font-size: 18px; color: var(--navy); margin-bottom: 20px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .form-group { margin-bottom: 14px; }
    .form-group label { display: block; font-size: 12.5px; font-weight: 600; color: var(--navy); margin-bottom: 6px; }
    .form-group label .req { color: var(--red); }
    .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid var(--gray-100); border-radius: var(--radius-sm); font-family: var(--font-body); font-size: 14px; color: var(--text); transition: border-color .2s, box-shadow .2s; background: var(--gray-50); outline: none; }
    .form-control:focus { border-color: var(--red); background: white; box-shadow: 0 0 0 3px rgba(200,16,46,.08); }
    select.form-control { cursor: pointer; }
    .btn-submit { width: 100%; padding: 13px; background: var(--red); color: white; border: none; border-radius: var(--radius-sm); font-family: var(--font-body); font-size: 15px; font-weight: 700; cursor: pointer; transition: all .25s; box-shadow: 0 4px 16px rgba(200,16,46,.3); display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 6px; }
    .btn-submit:hover { background: var(--red-dark); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(200,16,46,.4); }
    .alert-success { background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; font-weight: 500; }

    /* ===== RESPONSIVE ===== */
    @@media (max-width: 1024px) {
        .okgrid { grid-template-columns: 1fr; }
        .ok-side { flex-direction: row; }
        .ok-side-img { flex: 1; height: 160px; }
        .nckh-card { grid-template-columns: 1fr; }
        .nckh-img { height: 240px; }
        .nckh-slider-track { min-height: 500px; }
        .visao-grid { grid-template-columns: 1fr; }
        .visao-img-wrap { height: 260px; }
        .hocbong-grid { grid-template-columns: 1fr 1fr; }
    }
    @@media (max-width: 768px) {
        .hero { height: 460px; }
        .stats-bar .inner { grid-template-columns: 1fr 1fr; }
        .stat-item:nth-child(2) { border-right: none; }
        .ok-thumbs { grid-template-columns: 1fr 1fr; }
        .hocbong-grid { grid-template-columns: 1fr; }
        .tuvan-inner { grid-template-columns: 1fr; }
        .tuvan-wrap { padding: 36px 24px; }
        .form-row { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')

{{-- ===== HERO SLIDER ===== --}}
{{--
    Nguồn: bảng Banner (vi_tri='trang_chu', is_hien_thi=1, còn trong hạn ngày)
    Nếu chưa có banner nào trong DB thì hiện slide mặc định bên dưới
--}}
<section class="hero" id="hero">
    @if($bannerList->isNotEmpty())
        @foreach($bannerList as $i => $banner)
            <div class="hero-slide {{ $i === 0 ? 'active' : '' }}">
                <div class="bg" style="background-image:url('{{ asset($banner->duong_dan_anh) }}')"></div>
                <div class="hero-content">
                    <div class="hero-badge"><span class="dot"></span>Tuyển sinh 2026 đang mở</div>
                    <h1>{{ $banner->tieu_de }}</h1>
                    @if($banner->mo_ta)
                        <p>{{ $banner->mo_ta }}</p>
                    @endif
                    <div class="hero-ctas">
                        <a href="{{ url('/ho-so/dang-ky') }}" class="hero-cta-primary">
                            <i class="fas fa-rocket"></i> Đăng ký ngay
                        </a>
                        @if($banner->url_lien_ket)
                            <a href="{{ $banner->url_lien_ket }}" class="hero-cta-secondary">
                                <i class="fas fa-info-circle"></i> Xem thêm
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @else
        {{-- Slide dự phòng khi DB chưa có banner --}}
        <div class="hero-slide active">
            <div class="bg" style="background-image:url('https://stu.exproweb.com/upload/images/STU001/Banner/BANNER_2026.png')"></div>
            <div class="hero-content">
                <div class="hero-badge"><span class="dot"></span>Tuyển sinh 2026 đang mở</div>
                <h1>Kiến tạo tương lai<br>cùng <span class="accent">STU</span></h1>
                <p>3.000 chỉ tiêu — 18 ngành học — 5 phương thức xét tuyển.<br>Học bổng lên đến 100% học phí.</p>
                <div class="hero-ctas">
                    <a href="{{ url('/ho-so/dang-ky') }}" class="hero-cta-primary"><i class="fas fa-rocket"></i> Đăng ký ngay</a>
                    <a href="{{ url('/nganh-hoc') }}" class="hero-cta-secondary"><i class="fas fa-search"></i> Khám phá ngành học</a>
                </div>
            </div>
        </div>
    @endif

    {{-- Dots điều hướng --}}
    @if($bannerList->count() > 1)
        <div class="hero-dots">
            @foreach($bannerList as $i => $banner)
                <div class="hero-dot {{ $i === 0 ? 'active' : '' }}" onclick="goSlide({{ $i }})"></div>
            @endforeach
        </div>
    @endif
</section>

{{-- ===== STATS BAR ===== --}}
{{--
    Lấy tổng chỉ tiêu từ ChiTieu (đợt đang_mo hoặc da_cong_bo)
    và tổng ngành từ NganhHoc (trang_thai=1)
    Các chỉ số còn lại là cố định của trường
--}}
<div class="stats-bar">
    <div class="inner">
        <div class="stat-item">
            <div class="stat-num">{{ number_format($nganhList->sum('chi_tieu') ?: 3000) }}</div>
            <div class="stat-label">Chỉ tiêu tuyển sinh 2026</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">{{ $nganhList->count() ?: 18 }}</div>
            <div class="stat-label">Ngành đào tạo</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">96%</div>
            <div class="stat-label">Sinh viên có việc làm</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">30+</div>
            <div class="stat-label">Năm kinh nghiệm</div>
        </div>
    </div>
</div>

{{-- ===== PHUONG THUC XET TUYEN ===== --}}
{{-- Nguồn: bảng PhuongThucXT (is_active=1) --}}
<section class="section">
    <div class="container">
        <div class="section-head" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:16px">
            <div>
                <div class="section-label">Tuyển sinh 2026</div>
                <h2 class="section-title">Phương thức xét tuyển</h2>
                <p class="section-desc">STU áp dụng {{ $phuongThucList->count() }} phương thức xét tuyển đa dạng, tạo cơ hội bình đẳng cho mọi thí sinh.</p>
            </div>
            <a href="{{ url('/tuyen-sinh/phuong-thuc') }}" class="see-more">Xem chi tiết <i class="fas fa-arrow-right"></i></a>
        </div>

        @php
            // Map icon theo loai_diem
            $ptIcons = [
                'hoc_ba'             => 'fas fa-book-open',
                'thi_thpt'           => 'fas fa-file-alt',
                'danh_gia_nang_luc'  => 'fas fa-brain',
            ];
        @endphp

        <div class="method-grid">
            @foreach($phuongThucList as $pt)
                <div class="method-card">
                    <div class="method-icon">
                        <i class="{{ $ptIcons[$pt->loai_diem] ?? 'fas fa-graduation-cap' }}"></i>
                    </div>
                    <span class="method-code">{{ $pt->ma_phuong_thuc }}</span>
                    <div class="method-name">{{ $pt->ten_phuong_thuc }}</div>
                    <div class="method-desc">{{ $pt->mo_ta }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== NGANH HOC ===== --}}
{{-- Nguồn: bảng NganhHoc (trang_thai=1) join Khoa, ChiTieu lấy diem_chuan --}}
<section class="section section-alt">
    <div class="container">
        <div class="section-head" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:16px">
            <div>
                <div class="section-label">Đào tạo</div>
                <h2 class="section-title">Ngành học nổi bật</h2>
                <p class="section-desc">{{ $nganhList->count() }} ngành đào tạo chính quy, gắn kết doanh nghiệp, đảm bảo đầu ra việc làm.</p>
            </div>
            <a href="{{ url('/nganh-hoc') }}" class="see-more">Tất cả ngành <i class="fas fa-arrow-right"></i></a>
        </div>

        {{-- Tab lọc theo khoa --}}
        <div class="nganh-tabs" id="nganh-tabs">
            <div class="nganh-tab on" data-khoa="all">Tất cả</div>
            @foreach($khoaList as $khoa)
                <div class="nganh-tab" data-khoa="{{ $khoa->id }}">{{ $khoa->ten_khoa }}</div>
            @endforeach
        </div>

        @php
            // Icon theo ma_khoa
            $khoaIcons = [
                'CNTT' => '💻', 'KTDD' => '⚡', 'CK' => '🔧',
                'KT'   => '📊', 'XD'   => '🏗️',
            ];
        @endphp

        <div class="nganh-grid" id="nganh-grid">
            @foreach($nganhList as $nganh)
                <a href="{{ url('/nganh-hoc/' . $nganh->id) }}"
                   class="nganh-card"
                   data-khoa="{{ $nganh->khoa_id }}">
                    <div class="nganh-icon">
                        {{ $khoaIcons[$nganh->khoa->ma_khoa ?? ''] ?? '🎓' }}
                    </div>
                    <div class="nganh-info">
                        <div class="nganh-name">{{ $nganh->ten_nganh }}</div>
                        <div class="nganh-meta">
                            @if($nganh->chi_tieu)
                                <span><i class="fas fa-users"></i> {{ number_format($nganh->chi_tieu) }} chỉ tiêu</span>
                            @endif
                            <span><i class="fas fa-clock"></i> {{ $nganh->thoi_gian_dao_tao }} năm</span>
                        </div>
                        @if($nganh->diem_chuan)
                            <span class="nganh-score">Điểm chuẩn 2025: {{ $nganh->diem_chuan }}</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== TIN TUC + SU KIEN ===== --}}
{{--
    Tin tức: bảng BaiViet (trang_thai='da_xuat_ban', mới nhất)
    Sự kiện: bảng SuKien (is_hien_thi=1, ngay_to_chuc >= now, sắp diễn ra)
--}}
<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:1.6fr 1fr;gap:48px;align-items:start">

            {{-- TIN TỨC --}}
            <div>
                <div class="section-head" style="display:flex;justify-content:space-between;align-items:center">
                    <div>
                        <div class="section-label">Tin tức</div>
                        <h2 class="section-title">Thông tin tuyển sinh</h2>
                    </div>
                    <a href="{{ url('/tin-tuc') }}" class="see-more">Xem thêm <i class="fas fa-arrow-right"></i></a>
                </div>
                <div style="display:flex;flex-direction:column;gap:16px">
                    @foreach($tinTucList as $i => $tin)
                        @if($i === 0)
                            <a href="{{ url('/tin-tuc/' . $tin->slug) }}" class="news-featured">
                                <div class="img-wrap">
                                    <img src="{{ asset($tin->anh) }}"
                                         alt="{{ $tin->tieu_de }}"
                                         loading="lazy"
                                         onerror="this.src='https://stu.exproweb.com/upload/images/STU001/News/Moc%20thoi%20gian%20can%20nho%202026.jpg'">
                                </div>
                                <div class="body">
                                    <span class="news-tag">{{ $tin->danh_muc }}</span>
                                    <div class="news-title">{{ $tin->tieu_de }}</div>
                                    <div class="news-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($tin->ngay_dang)->format('d/m/Y') }}
                                    </div>
                                </div>
                            </a>
                        @else
                            <a href="{{ url('/tin-tuc/' . $tin->slug) }}" class="news-item">
                                <div class="thumb">
                                    <img src="{{ asset($tin->anh) }}"
                                         alt="{{ $tin->tieu_de }}"
                                         loading="lazy"
                                         onerror="this.src='https://stu.exproweb.com/upload/images/news/news-2.jpg'">
                                </div>
                                <div class="info">
                                    <span class="news-tag">{{ $tin->danh_muc }}</span>
                                    <div class="news-title">{{ $tin->tieu_de }}</div>
                                    <div class="news-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($tin->ngay_dang)->format('d/m/Y') }}
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach

                    @if($tinTucList->isEmpty())
                        <p style="color:var(--gray-500);font-size:14px;padding:20px 0;">
                            Chưa có bài viết nào. Vui lòng thêm bài viết trong trang quản trị.
                        </p>
                    @endif
                </div>
            </div>

            {{-- SỰ KIỆN --}}
            <div>
                <div class="section-head" style="display:flex;justify-content:space-between;align-items:center">
                    <div>
                        <div class="section-label">Lịch sự kiện</div>
                        <h2 class="section-title">Sắp diễn ra</h2>
                    </div>
                    <a href="{{ url('/su-kien') }}" class="see-more">Tất cả <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="sukien-list">
                    @foreach($suKienList as $sk)
                        <a href="{{ url('/su-kien/' . $sk->id) }}" class="sukien-item">
                            <div class="sukien-date">
                                <div class="day">{{ \Carbon\Carbon::parse($sk->ngay_to_chuc)->format('d') }}</div>
                                <div class="month">Th{{ \Carbon\Carbon::parse($sk->ngay_to_chuc)->format('n') }}</div>
                            </div>
                            <div class="sukien-divider"></div>
                            <div class="sukien-info">
                                <div class="sukien-title">{{ $sk->tieu_de }}</div>
                                <div class="sukien-meta">
                                    <span>
                                        <i class="fas fa-{{ $sk->hinh_thuc === 'online' ? 'video' : 'map-marker-alt' }}"></i>
                                        {{ $sk->hinh_thuc === 'online' ? 'Trực tuyến' : $sk->dia_diem }}
                                    </span>
                                    <span class="sukien-tag {{ $sk->loai }}">{{ $sk->loai_label }}</span>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right sukien-arrow"></i>
                        </a>
                    @endforeach

                    @if($suKienList->isEmpty())
                        <p style="color:var(--gray-500);font-size:14px;padding:20px 0;">
                            Chưa có sự kiện nào sắp diễn ra.
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ===== HỌC BỔNG ===== --}}
{{-- Nguồn: bảng HocBong (trang_thai='dang_mo', còn trong hạn đăng ký) --}}
<section class="section section-alt">
    <div class="container">
        <div class="section-head" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:16px">
            <div>
                <div class="section-label">Học bổng</div>
                <h2 class="section-title">Chính sách hỗ trợ</h2>
                <p class="section-desc">STU dành nhiều suất học bổng giá trị cho tân sinh viên xứng đáng.</p>
            </div>
            <a href="{{ url('/hoc-bong') }}" class="see-more">Xem tất cả <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="hocbong-grid">
            @foreach($hocBongList as $hb)
                <a href="{{ url('/hoc-bong/' . $hb->id) }}" class="hocbong-card {{ $hb->card_class }}">
                    <div class="bg-deco"></div>
                    <div class="bg-deco2"></div>
                    <div class="hocbong-percent">{{ (int)$hb->phan_tram_mien_giam }}%</div>
                    <div class="hocbong-icon"><i class="{{ $hb->icon }}"></i></div>
                    <div class="hocbong-name">{{ $hb->ten_hoc_bong }}</div>
                    <div class="hocbong-desc">{{ $hb->mo_ta }}</div>
                    <span class="hocbong-value"><i class="fas fa-tag"></i> {{ $hb->gia_tri_label }}</span>
                </a>
            @endforeach

            @if($hocBongList->isEmpty())
                <div class="hocbong-card navy" style="grid-column:1/-1;align-items:center;text-align:center;">
                    <p>Chưa có học bổng nào đang mở. Vui lòng theo dõi thêm.</p>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- ===== STU QUA ỐNG KÍNH ===== --}}
{{-- Phần này dùng ảnh/video tĩnh của trường, không cần DB --}}
<section class="section" id="ong-kinh">
    <div class="container">
        <div class="section-head" style="text-align:left">
            <div class="section-label" style="justify-content:center">STU Qua Ống Kính</div>
        </div>
        <div class="okgrid">
            <div class="ok-main">
                <div class="ok-main-img">
                    <img src="https://stu.exproweb.com/upload/images/STU001/Banner/BANNER_2026.png" alt="STU Campus">
                    <a href="https://www.youtube.com/watch?v=N4ziA8NIQEs" target="_blank" class="ok-play">
                        <i class="fas fa-play"></i>
                    </a>
                </div>
                <div class="ok-thumbs">
                    <div class="ok-thumb"><img src="https://stu.exproweb.com/upload/images/about/about-2.jpg" alt=""></div>
                    <div class="ok-thumb"><img src="https://stu.exproweb.com/upload/images/about/about-3.jpg" alt=""></div>
                    <div class="ok-thumb"><img src="https://stu.exproweb.com/upload/images/about/about-4.jpg" alt=""></div>
                </div>
            </div>
            <div class="ok-side">
                <div class="ok-side-img"><img src="https://stu.exproweb.com/upload/images/STU001/News/STU%20Cover%20FB.png" alt=""></div>
                <div class="ok-side-img"><img src="https://stu.exproweb.com/upload/images/STU001/News/DNTP%202026.jpg" alt=""></div>
            </div>
        </div>
    </div>
</section>

{{-- ===== NGHIÊN CỨU KHOA HỌC ===== --}}
{{-- Nguồn: BaiViet danh mục slug='nghien-cuu-khoa-hoc' --}}
<section class="section section-alt" id="nckh">
    <div class="container">
        <div class="section-head" style="text-align:left">
            <div class="section-label" style="justify-content:center">Nghiên Cứu Khoa Học</div>
        </div>
        <div class="nckh-wrap">
            <div class="nckh-slider-track" id="nckh-track">
                @foreach($nckhList as $i => $nckh)
                    <div class="nckh-card {{ $i === 0 ? 'nckh-active' : '' }}">
                        <div class="nckh-img">
                            <img src="{{ asset($nckh->anh) }}"
                                 alt="{{ $nckh->tieu_de }}"
                                 onerror="this.src='https://stu.exproweb.com/upload/images/news/image014.jpg'">
                        </div>
                        <div class="nckh-caption">
                            <span class="nckh-date">{{ \Carbon\Carbon::parse($nckh->ngay)->format('d/m/Y') }}</span>
                            <a href="{{ url('/tin-tuc/' . $nckh->slug) }}" class="nckh-title">{{ $nckh->tieu_de }}</a>
                            <p class="nckh-desc">{{ $nckh->mo_ta }}</p>
                        </div>
                    </div>
                @endforeach

                @if($nckhList->isEmpty())
                    <div class="nckh-card nckh-active">
                        <div class="nckh-img">
                            <img src="https://stu.exproweb.com/upload/images/news/image014.jpg" alt="NCKH">
                        </div>
                        <div class="nckh-caption">
                            <span class="nckh-date">Cập nhật sớm</span>
                            <span class="nckh-title">Nghiên cứu khoa học tại STU</span>
                            <p class="nckh-desc">Vui lòng thêm bài viết danh mục "Nghiên cứu khoa học" trong trang quản trị để hiển thị tại đây.</p>
                        </div>
                    </div>
                @endif
            </div>

            @if($nckhList->count() > 1)
                <div class="nckh-controls">
                    <button class="nckh-btn" onclick="nckhPrev()"><i class="fas fa-chevron-left"></i></button>
                    <button class="nckh-btn" onclick="nckhNext()"><i class="fas fa-chevron-right"></i></button>
                </div>
                <div class="nckh-dots-row" id="nckh-dots">
                    @foreach($nckhList as $i => $nckh)
                        <div class="nckh-dot-item {{ $i === 0 ? 'on' : '' }}" onclick="nckhGo({{ $i }})"></div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>

{{-- ===== VÌ SAO CHỌN STU? ===== --}}
<section class="section" id="vi-sao-stu">
    <div class="container">
        <div class="section-head" style="text-align:left">
            <div class="section-label" style="justify-content:center">Vì Sao Chọn STU?</div>
        </div>
        <div class="visao-grid">
            <div class="visao-img-wrap">
                <img src="https://stu.exproweb.com/upload/images/about/about-3.jpg" alt="I Love STU">
                <div class="visao-img-badge">❤️ I Love STU</div>
            </div>
            <div class="visao-cards">
                <a href="{{ url('/gioi-thieu') }}" class="visao-card">
                    <div class="visao-card-left">
                        <div class="visao-icon"><i class="fas fa-layer-group"></i></div>
                        <div>
                            <div class="visao-title">Đa ngành ứng dụng</div>
                            <div class="visao-desc">Đào tạo từ kỹ thuật, công nghệ đến kinh tế, dịch vụ và thiết kế, mở rộng lựa chọn ngành nghề cho sinh viên.</div>
                        </div>
                    </div>
                    <i class="fas fa-arrow-up-right-from-square visao-arrow"></i>
                </a>
                <a href="{{ url('/co-so-vat-chat') }}" class="visao-card">
                    <div class="visao-card-left">
                        <div class="visao-icon"><i class="fas fa-flask"></i></div>
                        <div>
                            <div class="visao-title">Học đi đôi với hành</div>
                            <div class="visao-desc">Tăng cường thực hành tại phòng thí nghiệm, xưởng và dự án doanh nghiệp ngay trong chương trình học.</div>
                        </div>
                    </div>
                    <i class="fas fa-arrow-up-right-from-square visao-arrow"></i>
                </a>
                <a href="{{ url('/doi-tac') }}" class="visao-card">
                    <div class="visao-card-left">
                        <div class="visao-icon"><i class="fas fa-briefcase"></i></div>
                        <div>
                            <div class="visao-title">Kết nối doanh nghiệp &amp; việc làm</div>
                            <div class="visao-desc">Hợp tác với nhiều doanh nghiệp để tổ chức thực tập, tham quan, hội thảo và ngày hội việc làm cho sinh viên.</div>
                        </div>
                    </div>
                    <i class="fas fa-arrow-up-right-from-square visao-arrow"></i>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ===== FORM TƯ VẤN ===== --}}
{{-- POST đến TrangChuController@tuVan → lưu vào bảng YeuCauTuVan --}}
<section class="section" id="tu-van">
    <div class="container">
        <div class="tuvan-wrap">
            <div class="tuvan-inner">
                <div class="tuvan-left">
                    <div class="label">Hỗ trợ trực tiếp</div>
                    <h2>Đăng ký tư vấn<br>tuyển sinh miễn phí</h2>
                    <p>Đội ngũ tư vấn viên STU sẵn sàng giải đáp mọi thắc mắc về ngành học, phương thức xét tuyển, học bổng và lộ trình nộp hồ sơ.</p>
                    <div class="tuvan-contact">
                        <a href="tel:84838505520"><i class="fas fa-phone-alt"></i> (84.8) 3850 5520</a>
                        <a href="mailto:tuyensinh@stu.edu.vn"><i class="fas fa-envelope"></i> tuyensinh@stu.edu.vn</a>
                        <a href="https://facebook.com/STUAdmission" target="_blank"><i class="fab fa-facebook"></i> facebook.com/STUAdmission</a>
                        <a href="#"><i class="fas fa-map-marker-alt"></i> 180 Cao Lỗ, Q.8, TP.HCM</a>
                    </div>
                </div>
                <div class="tuvan-form">
                    <h3><i class="fas fa-paper-plane" style="color:var(--red);margin-right:8px"></i>Đăng ký nhận tư vấn</h3>

                    @if(session('success'))
                        <div class="alert-success">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ url('/tu-van') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label>Họ và tên <span class="req">*</span></label>
                                <input type="text" name="ho_ten" class="form-control"
                                       placeholder="Nguyễn Văn A"
                                       value="{{ old('ho_ten') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại <span class="req">*</span></label>
                                <input type="tel" name="so_dien_thoai" class="form-control"
                                       placeholder="0912 345 678"
                                       value="{{ old('so_dien_thoai') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control"
                                   placeholder="email@example.com"
                                   value="{{ old('email') }}">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Ngành quan tâm</label>
                                {{-- Danh sách ngành từ DB --}}
                                <select name="nganh_id" class="form-control">
                                    <option value="">-- Chọn ngành --</option>
                                    @foreach($nganhList as $nganh)
                                        <option value="{{ $nganh->id }}"
                                            {{ old('nganh_id') == $nganh->id ? 'selected' : '' }}>
                                            {{ $nganh->ten_nganh }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tỉnh / Thành phố</label>
                                <select name="tinh_thanh" class="form-control">
                                    <option value="">-- Chọn tỉnh thành --</option>
                                    @foreach(['TP. Hồ Chí Minh','Hà Nội','Bình Dương','Đồng Nai','Long An','Tỉnh / Thành khác'] as $tp)
                                        <option {{ old('tinh_thanh') === $tp ? 'selected' : '' }}>{{ $tp }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i> Gửi đăng ký tư vấn
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== ĐỐI TÁC ===== --}}
<section class="section section-alt" style="padding:40px 0">
    <div class="container">
        <div class="section-label" style="justify-content:center;display:flex;margin-bottom:20px">Đối tác doanh nghiệp</div>
        <div class="partner-track">
            <div class="partner-inner">
                @foreach(['Qualcomm','Vietcombank','RIKEI Vietnam','Daishin','WACOM','Horizon','OTIS','SATORI','Troy','WESET'] as $p)
                    <div class="partner-item">{{ $p }}</div>
                @endforeach
                @foreach(['Qualcomm','Vietcombank','RIKEI Vietnam','Daishin','WACOM','Horizon','OTIS','SATORI','Troy','WESET'] as $p)
                    <div class="partner-item">{{ $p }}</div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// ===== HERO SLIDER =====
let currentSlide = 0;
const slides = document.querySelectorAll('.hero-slide');
const dots   = document.querySelectorAll('.hero-dot');

function goSlide(index) {
    if (!slides[index]) return;
    slides[currentSlide].classList.remove('active');
    if (dots[currentSlide]) dots[currentSlide].classList.remove('active');
    currentSlide = index;
    slides[currentSlide].classList.add('active');
    if (dots[currentSlide]) dots[currentSlide].classList.add('active');
}

if (slides.length > 1) {
    setInterval(() => goSlide((currentSlide + 1) % slides.length), 5000);
}

// ===== NGANH TAB FILTER =====
// Lọc ngành theo khoa_id gắn trên data-khoa của từng .nganh-card
document.querySelectorAll('.nganh-tab').forEach(tab => {
    tab.addEventListener('click', function () {
        document.querySelectorAll('.nganh-tab').forEach(t => t.classList.remove('on'));
        this.classList.add('on');

        const khoa = this.dataset.khoa;
        document.querySelectorAll('.nganh-card').forEach(card => {
            if (khoa === 'all' || card.dataset.khoa === khoa) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

// ===== ANIMATE ON SCROLL =====
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.method-card, .nganh-card, .hocbong-card, .sukien-item').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity .4s ease, transform .4s ease';
    observer.observe(el);
});

// ===== NCKH SLIDER =====
let nckhCurrent = 0;
const nckhCards = document.querySelectorAll('.nckh-card');
const nckhDots  = document.querySelectorAll('.nckh-dot-item');

function nckhGo(index) {
    if (!nckhCards[index]) return;
    nckhCards[nckhCurrent].classList.remove('nckh-active');
    if (nckhDots[nckhCurrent]) nckhDots[nckhCurrent].classList.remove('on');
    nckhCurrent = index;
    nckhCards[nckhCurrent].classList.add('nckh-active');
    if (nckhDots[nckhCurrent]) nckhDots[nckhCurrent].classList.add('on');
}
function nckhNext() { nckhGo((nckhCurrent + 1) % nckhCards.length); }
function nckhPrev() { nckhGo((nckhCurrent - 1 + nckhCards.length) % nckhCards.length); }

if (nckhCards.length > 1) {
    setInterval(nckhNext, 5000);
}
</script>
@endpush