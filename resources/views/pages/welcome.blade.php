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
    .nganh-card { background: white; border: 1px solid var(--gray-100); border-radius: var(--radius-md); padding: 20px; display: flex; align-items: flex-start; gap: 14px; transition: all .25s; }
    .nganh-card:hover { border-color: var(--red); box-shadow: var(--shadow-card); }
    .nganh-icon { width: 44px; height: 44px; border-radius: 10px; background: var(--gray-50); display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
    .nganh-info { flex: 1; min-width: 0; }
    .nganh-name { font-weight: 700; font-size: 14px; color: var(--navy); line-height: 1.4; margin-bottom: 4px; }
    .nganh-meta { font-size: 12px; color: var(--gray-500); display: flex; align-items: center; gap: 10px; }
    .nganh-meta span { display: flex; align-items: center; gap: 4px; }
    .nganh-score { font-size: 11px; font-weight: 700; background: rgba(200,16,46,.08); color: var(--red); padding: 2px 8px; border-radius: 4px; margin-top: 6px; display: inline-block; }

    /* ===== TIN TUC ===== */
    .news-featured { border-radius: var(--radius-lg); overflow: hidden; background: white; box-shadow: var(--shadow-card); transition: box-shadow .3s; }
    .news-featured:hover { box-shadow: var(--shadow-hover); }
    .news-featured .img-wrap { height: 220px; overflow: hidden; }
    .news-featured .img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
    .news-featured:hover .img-wrap img { transform: scale(1.04); }
    .news-featured .body { padding: 22px; }
    .news-tag { display: inline-block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--red); margin-bottom: 8px; }
    .news-title { font-weight: 700; font-size: 15.5px; color: var(--navy); line-height: 1.45; margin-bottom: 8px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .news-date { font-size: 12px; color: var(--gray-500); display: flex; align-items: center; gap: 6px; }
    .news-item { background: white; border-radius: var(--radius-md); overflow: hidden; display: flex; gap: 14px; padding: 14px; box-shadow: var(--shadow-card); transition: box-shadow .3s; }
    .news-item:hover { box-shadow: var(--shadow-hover); }
    .news-item .thumb { width: 80px; height: 68px; border-radius: 8px; overflow: hidden; flex-shrink: 0; }
    .news-item .thumb img { width: 100%; height: 100%; object-fit: cover; }
    .news-item .info { flex: 1; }
    .news-item .news-title { font-size: 13.5px; -webkit-line-clamp: 3; }

    /* ===== SU KIEN ===== */
    .sukien-list { display: flex; flex-direction: column; gap: 14px; }
    .sukien-item { background: white; border-radius: var(--radius-md); padding: 18px 20px; display: flex; align-items: center; gap: 18px; border: 1px solid var(--gray-100); box-shadow: var(--shadow-card); transition: all .25s; }
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
    .hocbong-card { border-radius: var(--radius-lg); overflow: hidden; position: relative; background: var(--navy); color: white; padding: 32px 28px; min-height: 200px; display: flex; flex-direction: column; justify-content: flex-end; }
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
    .ok-main-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
    .ok-main-img:hover img { transform: scale(1.03); }
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
    .nckh-title { font-family: var(--font-display); font-size: 22px; font-weight: 700; color: var(--navy); line-height: 1.4; margin-bottom: 14px; display: block; transition: color .2s; }
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
    .visao-card { background: white; border: 1.5px solid var(--gray-100); border-radius: var(--radius-md); padding: 22px 20px; display: flex; align-items: center; justify-content: space-between; gap: 16px; transition: all .25s; }
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
<section class="hero" id="hero">
    {{-- Slide 1 --}}
    <div class="hero-slide active">
        <div class="bg" style="background-image:url('https://stu.exproweb.com/upload/images/STU001/Banner/BANNER_2026.png')"></div>
        <div class="hero-content">
            <div class="hero-badge"><span class="dot"></span>Tuyển sinh 2026 đang mở</div>
            <h1>Kiến tạo tương lai<br>cùng <span class="accent">STU</span></h1>
            <p>3.000 chỉ tiêu — 18 ngành học — 5 phương thức xét tuyển.<br>Học bổng lên đến 100% học phí dành cho tân sinh viên xuất sắc.</p>
            <div class="hero-ctas">
                <a href="{{ url('/ho-so/dang-ky') }}" class="hero-cta-primary"><i class="fas fa-rocket"></i> Đăng ký ngay</a>
                <a href="{{ url('/nganh-hoc') }}" class="hero-cta-secondary"><i class="fas fa-search"></i> Khám phá ngành học</a>
            </div>
        </div>
    </div>
    {{-- Slide 2 --}}
    <div class="hero-slide">
        <div class="bg" style="background-image:url('https://stu.exproweb.com/upload/images/banner/banner-2.jpg')"></div>
        <div class="hero-content">
            <div class="hero-badge"><span class="dot"></span>Học bổng tuyển sinh 2026</div>
            <h1>Học bổng <span class="accent">100%</span><br>dành cho bạn</h1>
            <p>STU trao hàng trăm suất học bổng cho thí sinh xuất sắc, hộ cận nghèo, và thí sinh đạt điểm cao.</p>
            <div class="hero-ctas">
                <a href="{{ url('/hoc-bong') }}" class="hero-cta-primary"><i class="fas fa-award"></i> Xem học bổng</a>
                <a href="{{ url('/tuyen-sinh') }}" class="hero-cta-secondary"><i class="fas fa-info-circle"></i> Thông tin xét tuyển</a>
            </div>
        </div>
    </div>
    {{-- Slide 3 --}}
    <div class="hero-slide">
        <div class="bg" style="background-image:url('https://stu.exproweb.com/upload/images/banner/banner-5.jpg')"></div>
        <div class="hero-content">
            <div class="hero-badge"><span class="dot"></span>96% sinh viên có việc làm</div>
            <h1>30 năm đào tạo<br><span class="accent">nhân lực chất lượng</span></h1>
            <p>Hơn 11.000 sinh viên đang theo học, 60+ phòng thí nghiệm hiện đại, kết nối hàng trăm doanh nghiệp đối tác.</p>
            <div class="hero-ctas">
                <a href="#gioi-thieu" class="hero-cta-primary"><i class="fas fa-university"></i> Tìm hiểu về STU</a>
                <a href="{{ url('/tuyen-sinh/phuong-thuc') }}" class="hero-cta-secondary"><i class="fas fa-list-check"></i> Phương thức xét tuyển</a>
            </div>
        </div>
    </div>
    {{-- Dots --}}
    <div class="hero-dots">
        <div class="hero-dot active" onclick="goSlide(0)"></div>
        <div class="hero-dot" onclick="goSlide(1)"></div>
        <div class="hero-dot" onclick="goSlide(2)"></div>
    </div>
</section>

{{-- ===== STATS BAR ===== --}}
<div class="stats-bar">
    <div class="inner">
        <div class="stat-item"><div class="stat-num">3.000</div><div class="stat-label">Chỉ tiêu tuyển sinh 2026</div></div>
        <div class="stat-item"><div class="stat-num">18</div><div class="stat-label">Ngành đào tạo</div></div>
        <div class="stat-item"><div class="stat-num">96%</div><div class="stat-label">Sinh viên có việc làm</div></div>
        <div class="stat-item"><div class="stat-num">30+</div><div class="stat-label">Năm kinh nghiệm</div></div>
    </div>
</div>

{{-- ===== PHUONG THUC XET TUYEN ===== --}}
<section class="section">
    <div class="container">
        <div class="section-head" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:16px">
            <div>
                <div class="section-label">Tuyển sinh 2026</div>
                <h2 class="section-title">Phương thức xét tuyển</h2>
                <p class="section-desc">STU áp dụng 5 phương thức xét tuyển đa dạng, tạo cơ hội bình đẳng cho mọi thí sinh.</p>
            </div>
            <a href="{{ url('/tuyen-sinh/phuong-thuc') }}" class="see-more">Xem chi tiết <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="method-grid">
            @forelse($phuongThucList ?? [] as $pt)
                <div class="method-card">
                    <div class="method-icon"><i class="{{ $pt->icon ?? 'fas fa-graduation-cap' }}"></i></div>
                    <span class="method-code">{{ $pt->ma_phuong_thuc }}</span>
                    <div class="method-name">{{ $pt->ten }}</div>
                    <div class="method-desc">{{ $pt->mo_ta }}</div>
                </div>
            @empty
                {{-- Fallback tĩnh --}}
                @foreach([
                    ['code'=>'PT01','icon'=>'fas fa-book-open','name'=>'Xét học bạ THPT','desc'=>'Dựa trên kết quả học bạ các học kỳ THPT theo tổ hợp môn xét tuyển.'],
                    ['code'=>'PT02','icon'=>'fas fa-file-alt','name'=>'Điểm thi tốt nghiệp THPT','desc'=>'Xét theo điểm thi tốt nghiệp THPT quốc gia và tổ hợp môn của ngành.'],
                    ['code'=>'PT03','icon'=>'fas fa-brain','name'=>'Đánh giá năng lực ĐHQG','desc'=>'Dựa trên kết quả kỳ thi Đánh giá năng lực do ĐHQG TP.HCM tổ chức.'],
                    ['code'=>'PT04','icon'=>'fas fa-medal','name'=>'Học sinh giỏi','desc'=>'Dành cho thí sinh có giải thi học sinh giỏi cấp tỉnh/thành phố trở lên.'],
                    ['code'=>'PT05','icon'=>'fas fa-exchange-alt','name'=>'Xét tuyển thẳng','desc'=>'Áp dụng cho thí sinh có thành tích đặc biệt theo quy định Bộ GD&ĐT.'],
                ] as $pt)
                    <div class="method-card">
                        <div class="method-icon"><i class="{{ $pt['icon'] }}"></i></div>
                        <span class="method-code">{{ $pt['code'] }}</span>
                        <div class="method-name">{{ $pt['name'] }}</div>
                        <div class="method-desc">{{ $pt['desc'] }}</div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- ===== NGANH HOC ===== --}}
<section class="section section-alt">
    <div class="container">
        <div class="section-head" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:16px">
            <div>
                <div class="section-label">Đào tạo</div>
                <h2 class="section-title">Ngành học nổi bật</h2>
                <p class="section-desc">18 ngành đào tạo chính quy, gắn kết doanh nghiệp, đảm bảo đầu ra việc làm.</p>
            </div>
            <a href="{{ url('/nganh-hoc') }}" class="see-more">Tất cả ngành <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="nganh-tabs" id="nganh-tabs">
            <div class="nganh-tab on" data-khoa="all">Tất cả</div>
            @forelse($khoaList ?? [] as $khoa)
                <div class="nganh-tab" data-khoa="{{ $khoa->id }}">{{ $khoa->ten_khoa }}</div>
            @empty
                @foreach(['cntt'=>'Công nghệ thông tin','kt'=>'Kinh tế – Quản trị','ck'=>'Cơ khí – Điện tử','xd'=>'Xây dựng','tp'=>'Thực phẩm'] as $key => $label)
                    <div class="nganh-tab" data-khoa="{{ $key }}">{{ $label }}</div>
                @endforeach
            @endforelse
        </div>

        <div class="nganh-grid" id="nganh-grid">
            @forelse($nganhList ?? [] as $nganh)
                <a href="{{ url('/nganh-hoc/' . $nganh->id) }}" class="nganh-card">
                    <div class="nganh-icon">{{ $nganh->icon ?? '🎓' }}</div>
                    <div class="nganh-info">
                        <div class="nganh-name">{{ $nganh->ten_nganh }}</div>
                        <div class="nganh-meta">
                            <span><i class="fas fa-users"></i> {{ number_format($nganh->chi_tieu) }} chỉ tiêu</span>
                            <span><i class="fas fa-clock"></i> 4 năm</span>
                        </div>
                        @if($nganh->diem_chuan)
                            <span class="nganh-score">Điểm chuẩn 2025: {{ $nganh->diem_chuan }}</span>
                        @endif
                    </div>
                </a>
            @empty
                @foreach([
                    ['icon'=>'💻','name'=>'Công nghệ thông tin','ct'=>400,'dc'=>'22.5'],
                    ['icon'=>'🔧','name'=>'Kỹ thuật Máy tính','ct'=>200,'dc'=>'21.0'],
                    ['icon'=>'📊','name'=>'Quản trị kinh doanh','ct'=>350,'dc'=>'20.0'],
                    ['icon'=>'📈','name'=>'Marketing','ct'=>300,'dc'=>'20.5'],
                    ['icon'=>'⚡','name'=>'Điện – Điện tử','ct'=>250,'dc'=>'19.5'],
                    ['icon'=>'🏗️','name'=>'Kỹ thuật Xây dựng','ct'=>200,'dc'=>'19.0'],
                    ['icon'=>'🍔','name'=>'Công nghệ Thực phẩm','ct'=>180,'dc'=>'18.5'],
                    ['icon'=>'🎨','name'=>'Thiết kế công nghiệp','ct'=>150,'dc'=>'20.0'],
                ] as $n)
                    <a href="#" class="nganh-card">
                        <div class="nganh-icon">{{ $n['icon'] }}</div>
                        <div class="nganh-info">
                            <div class="nganh-name">{{ $n['name'] }}</div>
                            <div class="nganh-meta">
                                <span><i class="fas fa-users"></i> {{ $n['ct'] }}</span>
                                <span><i class="fas fa-clock"></i> 4 năm</span>
                            </div>
                            <span class="nganh-score">Điểm chuẩn 2025: {{ $n['dc'] }}</span>
                        </div>
                    </a>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- ===== TIN TUC + SU KIEN ===== --}}
<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:1.6fr 1fr;gap:48px;align-items:start">

            {{-- TIN TUC --}}
            <div>
                <div class="section-head" style="display:flex;justify-content:space-between;align-items:center">
                    <div>
                        <div class="section-label">Tin tức</div>
                        <h2 class="section-title">Thông tin tuyển sinh</h2>
                    </div>
                    <a href="{{ url('/tin-tuc') }}" class="see-more">Xem thêm <i class="fas fa-arrow-right"></i></a>
                </div>
                <div style="display:flex;flex-direction:column;gap:16px">
                    @forelse($tinTucList ?? [] as $i => $tin)
                        @if($i === 0)
                            <a href="{{ url('/tin-tuc/' . $tin->slug) }}" class="news-featured">
                                <div class="img-wrap"><img src="{{ $tin->anh ?? '/images/default-news.jpg' }}" alt="{{ $tin->tieu_de }}" loading="lazy"></div>
                                <div class="body">
                                    <span class="news-tag">{{ $tin->danh_muc }}</span>
                                    <div class="news-title">{{ $tin->tieu_de }}</div>
                                    <div class="news-date"><i class="fas fa-calendar-alt"></i>{{ \Carbon\Carbon::parse($tin->ngay_dang)->format('d/m/Y') }}</div>
                                </div>
                            </a>
                        @else
                            <a href="{{ url('/tin-tuc/' . $tin->slug) }}" class="news-item">
                                <div class="thumb"><img src="{{ $tin->anh ?? '/images/default-news.jpg' }}" alt="" loading="lazy"></div>
                                <div class="info">
                                    <span class="news-tag">{{ $tin->danh_muc }}</span>
                                    <div class="news-title">{{ $tin->tieu_de }}</div>
                                    <div class="news-date"><i class="fas fa-calendar-alt"></i>{{ \Carbon\Carbon::parse($tin->ngay_dang)->format('d/m/Y') }}</div>
                                </div>
                            </a>
                        @endif
                    @empty
                        <a href="#" class="news-featured">
                            <div class="img-wrap"><img src="https://stu.exproweb.com/upload/images/STU001/News/Moc%20thoi%20gian%20can%20nho%202026.jpg" alt=""></div>
                            <div class="body">
                                <span class="news-tag">Tuyển sinh</span>
                                <div class="news-title">TUYỂN SINH 2026: Các mốc thời gian quan trọng cần nhớ</div>
                                <div class="news-date"><i class="fas fa-calendar-alt"></i>22/04/2026</div>
                            </div>
                        </a>
                        <a href="#" class="news-item">
                            <div class="thumb"><img src="https://stu.exproweb.com/upload/images/news/news-2.jpg" alt=""></div>
                            <div class="info">
                                <span class="news-tag">Điểm chuẩn</span>
                                <div class="news-title">Điểm chuẩn STU 2025 – Cập nhật mới nhất & so sánh xu hướng</div>
                                <div class="news-date"><i class="fas fa-calendar-alt"></i>16/01/2026</div>
                            </div>
                        </a>
                        <a href="#" class="news-item">
                            <div class="thumb"><img src="https://stu.exproweb.com/upload/images/STU001/News/Cau%20hoi%20TS%20t4%202026.jpg" alt=""></div>
                            <div class="info">
                                <span class="news-tag">Tư vấn</span>
                                <div class="news-title">20 câu hỏi tuyển sinh STU được hỏi nhiều nhất tháng 4</div>
                                <div class="news-date"><i class="fas fa-calendar-alt"></i>22/04/2026</div>
                            </div>
                        </a>
                    @endforelse
                </div>
            </div>

            {{-- SU KIEN --}}
            <div>
                <div class="section-head" style="display:flex;justify-content:space-between;align-items:center">
                    <div>
                        <div class="section-label">Lịch sự kiện</div>
                        <h2 class="section-title">Sắp diễn ra</h2>
                    </div>
                    <a href="{{ url('/su-kien') }}" class="see-more">Tất cả <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="sukien-list">
                    @forelse($suKienList ?? [] as $sk)
                        <a href="{{ url('/su-kien/' . $sk->id) }}" class="sukien-item">
                            <div class="sukien-date">
                                <div class="day">{{ \Carbon\Carbon::parse($sk->ngay_to_chuc)->format('d') }}</div>
                                <div class="month">{{ \Carbon\Carbon::parse($sk->ngay_to_chuc)->format('M') }}</div>
                            </div>
                            <div class="sukien-divider"></div>
                            <div class="sukien-info">
                                <div class="sukien-title">{{ $sk->ten_su_kien }}</div>
                                <div class="sukien-meta">
                                    <span><i class="fas fa-map-marker-alt"></i> {{ $sk->dia_diem }}</span>
                                    <span class="sukien-tag {{ $sk->loai }}">{{ $sk->loai_label }}</span>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right sukien-arrow"></i>
                        </a>
                    @empty
                        @foreach([
                            ['day'=>'25','month'=>'Th5','title'=>'Ngày hội tư vấn tuyển sinh STU 2026','place'=>'Hội trường A','tag'=>'tuvan','tag_label'=>'Tư vấn'],
                            ['day'=>'01','month'=>'Th6','title'=>'Workshop: Khám phá ngành Công nghệ thông tin','place'=>'Phòng B301','tag'=>'nganhhoc','tag_label'=>'Ngành học'],
                            ['day'=>'10','month'=>'Th6','title'=>'Hạn nộp hồ sơ xét học bổng đợt 1','place'=>'Online','tag'=>'hocbong','tag_label'=>'Học bổng'],
                            ['day'=>'15','month'=>'Th6','title'=>'Hội thảo hướng nghiệp cùng doanh nghiệp đối tác','place'=>'Sân khấu lớn','tag'=>'tuvan','tag_label'=>'Tư vấn'],
                        ] as $sk)
                            <a href="#" class="sukien-item">
                                <div class="sukien-date">
                                    <div class="day">{{ $sk['day'] }}</div>
                                    <div class="month">{{ $sk['month'] }}</div>
                                </div>
                                <div class="sukien-divider"></div>
                                <div class="sukien-info">
                                    <div class="sukien-title">{{ $sk['title'] }}</div>
                                    <div class="sukien-meta">
                                        <span><i class="fas fa-map-marker-alt"></i> {{ $sk['place'] }}</span>
                                        <span class="sukien-tag {{ $sk['tag'] }}">{{ $sk['tag_label'] }}</span>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right sukien-arrow"></i>
                            </a>
                        @endforeach
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ===== HOC BONG ===== --}}
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
            @forelse($hocBongList ?? [] as $hb)
                <a href="{{ url('/hoc-bong/' . $hb->id) }}" class="hocbong-card {{ $loop->first ? 'red' : ($loop->index == 1 ? 'gold' : 'navy') }}">
                    <div class="bg-deco"></div><div class="bg-deco2"></div>
                    <div class="hocbong-percent">{{ $hb->phan_tram }}%</div>
                    <div class="hocbong-icon"><i class="{{ $hb->icon ?? 'fas fa-award' }}"></i></div>
                    <div class="hocbong-name">{{ $hb->ten }}</div>
                    <div class="hocbong-desc">{{ $hb->mo_ta }}</div>
                    <span class="hocbong-value"><i class="fas fa-tag"></i> {{ $hb->gia_tri_label }}</span>
                </a>
            @empty
                @foreach([
                    ['class'=>'red','pct'=>'100','icon'=>'fas fa-trophy','name'=>'Học bổng Xuất sắc','desc'=>'Dành cho thí sinh có điểm xét tuyển từ 27 trở lên hoặc giải học sinh giỏi quốc gia.','label'=>'Miễn 100% học phí'],
                    ['class'=>'gold','pct'=>'50','icon'=>'fas fa-star','name'=>'Học bổng Khuyến khích','desc'=>'Dành cho thí sinh có điểm xét tuyển từ 24–26,75 và học lực giỏi liên tục.','label'=>'Giảm 50% học phí'],
                    ['class'=>'navy','pct'=>'25','icon'=>'fas fa-hand-holding-heart','name'=>'Học bổng Hỗ trợ','desc'=>'Dành cho sinh viên có hoàn cảnh khó khăn, thuộc hộ cận nghèo hoặc vùng đặc biệt khó khăn.','label'=>'Giảm 25% học phí'],
                ] as $hb)
                    <a href="#" class="hocbong-card {{ $hb['class'] }}">
                        <div class="bg-deco"></div><div class="bg-deco2"></div>
                        <div class="hocbong-percent">{{ $hb['pct'] }}%</div>
                        <div class="hocbong-icon"><i class="{{ $hb['icon'] }}"></i></div>
                        <div class="hocbong-name">{{ $hb['name'] }}</div>
                        <div class="hocbong-desc">{{ $hb['desc'] }}</div>
                        <span class="hocbong-value"><i class="fas fa-tag"></i> {{ $hb['label'] }}</span>
                    </a>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- ===== STU QUA ONG KINH ===== --}}
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

{{-- ===== NGHIEN CUU KHOA HOC ===== --}}
<section class="section section-alt" id="nckh">
    <div class="container">
        <div class="section-head" style="text-align:left">
            <div class="section-label" style="justify-content:center">Nghiên Cứu Khoa Học</div>
        </div>
        <div class="nckh-wrap">
            <div class="nckh-slider-track" id="nckh-track">
                @forelse($nckhList ?? [] as $i => $nckh)
                    <div class="nckh-card {{ $i === 0 ? 'nckh-active' : '' }}">
                        <div class="nckh-img"><img src="{{ $nckh->anh }}" alt="{{ $nckh->tieu_de }}"></div>
                        <div class="nckh-caption">
                            <span class="nckh-date">{{ \Carbon\Carbon::parse($nckh->ngay)->format('d/m/Y') }}</span>
                            <a href="{{ url('/nghien-cuu/' . $nckh->id) }}" class="nckh-title">{{ $nckh->tieu_de }}</a>
                            <p class="nckh-desc">{{ $nckh->mo_ta }}</p>
                        </div>
                    </div>
                @empty
                    @foreach([
                        ['img'=>'https://stu.exproweb.com/upload/images/news/image014.jpg','date'=>'18/12/2025','title'=>'Phòng Thí nghiệm Công nghệ Sinh học Thực phẩm','desc'=>'Phòng Thí nghiệm Công nghệ Sinh học Thực phẩm — nơi sinh viên nghiên cứu và thực hành chuyên sâu.'],
                        ['img'=>'https://stu.exproweb.com/upload/images/news/YSC6.jpg','date'=>'18/12/2025','title'=>'Hội nghị Khoa học Sinh viên STU 2025','desc'=>'Sân chơi học thuật cho sinh viên STU trình bày các công trình nghiên cứu khoa học.'],
                        ['img'=>'https://stu.exproweb.com/upload/images/news/ICITE1.jpg','date'=>'18/12/2025','title'=>'Hội nghị Quốc tế ICITE 2025','desc'=>'STU đồng tổ chức hội nghị quốc tế về công nghệ và kỹ thuật hiện đại.'],
                    ] as $i => $nckh)
                        <div class="nckh-card {{ $i === 0 ? 'nckh-active' : '' }}">
                            <div class="nckh-img"><img src="{{ $nckh['img'] }}" alt="{{ $nckh['title'] }}"></div>
                            <div class="nckh-caption">
                                <span class="nckh-date">{{ $nckh['date'] }}</span>
                                <a href="#" class="nckh-title">{{ $nckh['title'] }}</a>
                                <p class="nckh-desc">{{ $nckh['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                @endforelse
            </div>
            <div class="nckh-controls">
                <button class="nckh-btn" onclick="nckhPrev()"><i class="fas fa-chevron-left"></i></button>
                <button class="nckh-btn" onclick="nckhNext()"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="nckh-dots-row" id="nckh-dots">
                @for($i = 0; $i < max(count($nckhList ?? []), 3); $i++)
                    <div class="nckh-dot-item {{ $i === 0 ? 'on' : '' }}" onclick="nckhGo({{ $i }})"></div>
                @endfor
            </div>
        </div>
    </div>
</section>

{{-- ===== VI SAO CHON STU ===== --}}
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
                <a href="#" class="visao-card">
                    <div class="visao-card-left">
                        <div class="visao-icon"><i class="fas fa-layer-group"></i></div>
                        <div>
                            <div class="visao-title">Đa ngành ứng dụng</div>
                            <div class="visao-desc">Đào tạo từ kỹ thuật, công nghệ đến kinh tế, dịch vụ và thiết kế, mở rộng lựa chọn ngành nghề cho sinh viên.</div>
                        </div>
                    </div>
                    <i class="fas fa-arrow-up-right-from-square visao-arrow"></i>
                </a>
                <a href="#" class="visao-card">
                    <div class="visao-card-left">
                        <div class="visao-icon"><i class="fas fa-flask"></i></div>
                        <div>
                            <div class="visao-title">Học đi đôi với hành</div>
                            <div class="visao-desc">Tăng cường thực hành tại phòng thí nghiệm, xưởng và dự án doanh nghiệp ngay trong chương trình học.</div>
                        </div>
                    </div>
                    <i class="fas fa-arrow-up-right-from-square visao-arrow"></i>
                </a>
                <a href="#" class="visao-card">
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

{{-- ===== FORM TU VAN ===== --}}
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
                        <a href="#"><i class="fab fa-facebook"></i> facebook.com/STUAdmission</a>
                        <a href="#"><i class="fas fa-map-marker-alt"></i> 180 Cao Lỗ, Q.8, TP.HCM</a>
                    </div>
                </div>
                <div class="tuvan-form">
                    <h3><i class="fas fa-paper-plane" style="color:var(--red);margin-right:8px"></i>Đăng ký nhận tư vấn</h3>
                    <form action="{{ url('/tu-van') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label>Họ và tên <span class="req">*</span></label>
                                <input type="text" name="ho_ten" class="form-control" placeholder="Nguyễn Văn A" required>
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại <span class="req">*</span></label>
                                <input type="tel" name="so_dien_thoai" class="form-control" placeholder="0912 345 678" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@example.com">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Ngành quan tâm</label>
                                <select name="nganh_id" class="form-control">
                                    <option value="">-- Chọn ngành --</option>
                                    @forelse($nganhList ?? [] as $nganh)
                                        <option value="{{ $nganh->id }}">{{ $nganh->ten_nganh }}</option>
                                    @empty
                                        <option>Công nghệ thông tin</option>
                                        <option>Quản trị kinh doanh</option>
                                        <option>Kỹ thuật Điện – Điện tử</option>
                                        <option>Công nghệ Thực phẩm</option>
                                        <option>Thiết kế công nghiệp</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tỉnh / Thành phố</label>
                                <select name="tinh_thanh" class="form-control">
                                    <option value="">-- Chọn tỉnh thành --</option>
                                    @foreach(['TP. Hồ Chí Minh','Hà Nội','Bình Dương','Đồng Nai','Long An','Tỉnh / Thành khác'] as $tp)
                                        <option>{{ $tp }}</option>
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

{{-- ===== DOI TAC ===== --}}
<section class="section section-alt" style="padding:40px 0">
    <div class="container">
        <div class="section-label" style="justify-content:center;display:flex;margin-bottom:20px">Đối tác doanh nghiệp</div>
        <div class="partner-track">
            <div class="partner-inner">
                @foreach(['Qualcomm','Vietcombank','RIKEI Vietnam','Daishin','WACOM','Horizon','OTIS','SATORI','Troy','WESET'] as $p)
                    <div class="partner-item">{{ $p }}</div>
                @endforeach
                {{-- Clone for infinite scroll --}}
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
        slides[currentSlide].classList.remove('active');
        dots[currentSlide].classList.remove('active');
        currentSlide = index;
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
    }
    setInterval(() => goSlide((currentSlide + 1) % slides.length), 5000);

    // ===== NGANH TAB FILTER =====
    document.querySelectorAll('.nganh-tab').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.nganh-tab').forEach(t => t.classList.remove('on'));
            this.classList.add('on');
            // Filter server-side hoặc dùng Livewire / Alpine.js
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
        nckhCards[nckhCurrent].classList.remove('nckh-active');
        nckhDots[nckhCurrent].classList.remove('on');
        nckhCurrent = index;
        nckhCards[nckhCurrent].classList.add('nckh-active');
        nckhDots[nckhCurrent].classList.add('on');
    }
    function nckhNext() { nckhGo((nckhCurrent + 1) % nckhCards.length); }
    function nckhPrev() { nckhGo((nckhCurrent - 1 + nckhCards.length) % nckhCards.length); }
    setInterval(nckhNext, 5000);
</script>
@endpush