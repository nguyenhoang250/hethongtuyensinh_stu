<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tuyển Sinh 2026 — Đại học Công nghệ Sài Gòn (STU)')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,700;0,900;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --navy:       #005B96;
            --navy-mid:   #0A6FB3;
            --blue:       #0D47A1;
            --blue-dark:  #083A84;
            --blue-light: #1976D2;
            --red:        #D71920;
            --red-dark:   #B51218;
            --red-light:  #F03A40;
            --gold:       #F2B233;
            --gold-light: #FFD15C;
            --white:      #FFFFFF;
            --text:       #1C2B39;
            --gray-50:    #F7FAFC;
            --gray-100:   #EAF0F5;
            --gray-300:   #C7D3DF;
            --gray-500:   #708399;
            --gray-700:   #32485C;
            --radius-sm:  6px;
            --radius-md:  12px;
            --radius-lg:  20px;
            --shadow-card:  0 4px 24px rgba(13,71,161,.08);
            --shadow-hover: 0 12px 40px rgba(13,71,161,.16);
            --font-display: 'Playfair Display', serif;
            --font-body:    'Be Vietnam Pro', sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font-body); color: var(--text); background: var(--white); overflow-x: hidden; }
        img { max-width: 100%; display: block; }
        a { text-decoration: none; color: inherit; }

        /* TOPBAR */
        .topbar { background: var(--navy); color: rgba(255,255,255,.78); font-size: 12px; padding: 6px 0; }
        .topbar .inner { max-width: 1240px; margin: 0 auto; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; }
        .topbar-left, .topbar-right { display: flex; align-items: center; gap: 18px; }
        .topbar a, .topbar span.tb-info { color: rgba(255,255,255,.78); display: flex; align-items: center; gap: 5px; font-size: 11.5px; transition: color .2s; }
        .topbar a:hover { color: var(--gold-light); }
        .topbar i { color: var(--gold); font-size: 10px; }
        .tb-divider { width: 1px; height: 12px; background: rgba(255,255,255,.2); flex-shrink: 0; }

        /* NAVBAR */
        .navbar { background: var(--white); border-bottom: 2px solid var(--gray-100); box-shadow: 0 2px 16px rgba(13,27,62,.07); }
        .navbar .inner { max-width: 1240px; margin: 0 auto; padding: 0 24px; display: flex; align-items: center; height: 68px; gap: 6px; }

        /* LOGO */
        .navbar-logo { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
        .navbar-logo .logo-mark { width: 48px; height: 48px; border-radius: 8px; display: flex; align-items: center; justify-content: center; overflow: hidden; background: transparent; }
        .navbar-logo .logo-mark img { width: 100%; height: 100%; object-fit: contain; }
        .navbar-logo .logo-text { line-height: 1.25; }
        .navbar-logo .logo-name { font-weight: 800; font-size: 13.5px; color: var(--navy); white-space: nowrap; }
        .navbar-logo .logo-sub  { font-size: 10.5px; color: var(--gray-500); font-weight: 500; white-space: nowrap; }
        .nav-sep { width: 1px; height: 32px; background: var(--gray-100); flex-shrink: 0; margin: 0 6px; }

        /* NAV LINKS */
        .navbar-nav { display: flex; align-items: center; flex: 1; list-style: none; gap: 2px; }
        .navbar-nav > li { position: relative; }
        .navbar-nav > li > a { display: flex; align-items: center; gap: 4px; padding: 8px 11px; font-weight: 700; font-size: 13px; color: var(--gray-700); border-radius: var(--radius-sm); transition: all .18s; white-space: nowrap; }
        .navbar-nav > li > a:hover { background: rgba(13,71,161,.07); color: var(--blue); }
        .navbar-nav > li > a.active { color: var(--blue); background: rgba(13,71,161,.08); }
        .navbar-nav > li > a.active::after { content: ''; position: absolute; bottom: -2px; left: 11px; right: 11px; height: 2.5px; background: var(--blue); border-radius: 2px; }
        .dd-arrow { font-size: 9px; opacity: .45; margin-left: 1px; display: inline-flex; transition: transform .18s; }
        .navbar-nav > li:hover .dd-arrow { transform: rotate(180deg); opacity: .75; }

        /* DROPDOWN */
        .navbar-nav .has-dropdown { position: relative; }
        .navbar-nav .has-dropdown .dropdown { display: none; position: absolute; top: calc(100% + 8px); left: 0; background: var(--white); border: 1px solid var(--gray-100); border-radius: 16px; padding: 6px; list-style: none; min-width: 260px; box-shadow: 0 8px 32px rgba(13,27,62,.12); z-index: 1050; }
        .navbar-nav .has-dropdown:hover .dropdown { display: block; }
        .dropdown .dd-group-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--gray-500); padding: 8px 10px 4px; }
        .dropdown .dd-divider { height: 1px; background: var(--gray-100); margin: 5px 4px; }
        .dropdown .dd-item { display: flex; align-items: center; gap: 10px; padding: 8px 10px; border-radius: 10px; color: var(--gray-700); transition: background .14s; }
        .dropdown .dd-item:hover, .dropdown .dd-item.active { background: var(--gray-50); color: var(--blue); }
        .dropdown .dd-item.active::after { display: none; }
        .dropdown .dd-icon { width: 32px; height: 32px; border-radius: 8px; background: rgba(215,25,32,.07); display: flex; align-items: center; justify-content: center; font-size: 12px; color: var(--red); flex-shrink: 0; transition: background .14s; }
        .dropdown .dd-item:hover .dd-icon { background: rgba(215,25,32,.13); }
        .dropdown .dd-text { display: flex; flex-direction: column; gap: 1px; }
        .dropdown .dd-title { font-size: 13px; font-weight: 700; color: var(--gray-700); line-height: 1.2; }
        .dropdown .dd-desc  { font-size: 11px; color: var(--gray-500); font-weight: 400; line-height: 1.3; }
        .dropdown .dd-item:hover .dd-title { color: var(--blue); }
        .dropdown .dd-cta { background: rgba(215,25,32,.04); border: 1px dashed rgba(215,25,32,.28); margin-top: 2px; }
        .dropdown .dd-cta:hover { background: rgba(215,25,32,.09); }
        .dropdown .dd-cta:hover .dd-title { color: var(--red); }
        .dropdown .dd-cta .dd-icon { background: rgba(215,25,32,.12); }
        .dropdown .dd-cta:hover .dd-icon { background: rgba(215,25,32,.2); }
        .dd-cta-arrow { margin-left: auto; font-size: 11px; color: var(--red); opacity: .6; }

        /* NAVBAR ACTIONS */
        .navbar-actions { display: flex; align-items: center; gap: 6px; margin-left: auto; flex-shrink: 0; }

        .btn-ghost { padding: 7px 15px; border: 1.5px solid var(--gray-300); border-radius: 50px; color: var(--gray-700); font-weight: 600; font-size: 12.5px; background: none; cursor: pointer; transition: all .2s; white-space: nowrap; font-family: var(--font-body); }
        .btn-ghost:hover { border-color: var(--navy); color: var(--navy); background: rgba(0,91,150,.04); }
        .btn-login { padding: 7px 15px; border: 1.5px solid var(--navy); border-radius: 50px; color: var(--navy); font-weight: 700; font-size: 12.5px; display: inline-flex; align-items: center; gap: 6px; transition: all .25s; white-space: nowrap; }
        .btn-login:hover { background: var(--navy); color: white; }
        .btn-primary { padding: 7px 16px; background: var(--red); border-radius: 50px; color: white; font-weight: 700; font-size: 12.5px; white-space: nowrap; display: inline-flex; align-items: center; gap: 6px; transition: all .25s; cursor: pointer; border: none; box-shadow: 0 4px 16px rgba(215,25,32,.3); font-family: var(--font-body); }
        .btn-primary:hover { background: var(--red-dark); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(215,25,32,.4); }

        /* NOTIF BELL */
        .notif-btn { position: relative; width: 38px; height: 38px; border-radius: 50%; background: var(--gray-50); border: 1.5px solid var(--gray-100); display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--navy); font-size: 15px; transition: all .2s; flex-shrink: 0; }
        .notif-btn:hover { background: var(--gray-100); border-color: var(--gray-300); }
        .notif-badge { position: absolute; top: -4px; right: -4px; background: var(--red); color: white; font-size: 9px; font-weight: 700; width: 16px; height: 16px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid white; }

        /* USER CHIP + DROPDOWN — quan trọng: wrapper có position:relative */
        .user-chip-wrap { position: relative; flex-shrink: 0; }
        .user-chip { display: flex; align-items: center; gap: 8px; padding: 5px 12px 5px 6px; border: 1.5px solid var(--gray-100); border-radius: 50px; cursor: pointer; transition: border-color .2s; user-select: none; }
        .user-chip:hover { border-color: var(--gray-300); }
        .user-avatar { width: 30px; height: 30px; border-radius: 50%; background: var(--red); color: white; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0; }
        .user-chip-name { font-size: 13px; font-weight: 600; color: var(--navy); }
        .user-chip-arrow { font-size: 11px; color: var(--gray-500); transition: transform .2s; }
        .user-chip-arrow.open { transform: rotate(180deg); }

        /* Dropdown bám vào .user-chip-wrap */
        .user-dropdown { position: absolute; top: calc(100% + 10px); right: 0; background: white; border: 1px solid var(--gray-100); border-radius: var(--radius-lg); padding: 8px; min-width: 220px; z-index: 1100; box-shadow: 0 8px 32px rgba(13,27,62,.14); opacity: 0; pointer-events: none; transform: translateY(-8px); transition: opacity .2s, transform .2s; }
        .user-dropdown.show { opacity: 1; pointer-events: all; transform: translateY(0); }
        .ud-header { padding: 10px 12px 12px; border-bottom: 1px solid var(--gray-100); margin-bottom: 6px; }
        .ud-name { font-weight: 700; font-size: 14px; color: var(--navy); }
        .ud-meta { font-size: 11.5px; color: var(--gray-500); margin-top: 3px; display: flex; align-items: center; gap: 6px; }
        .ud-dot { width: 6px; height: 6px; background: #22c55e; border-radius: 50%; display: inline-block; }
        .ud-item { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: 8px; font-size: 13px; color: var(--gray-700); transition: background .15s; width: 100%; border: none; background: none; cursor: pointer; text-align: left; font-family: var(--font-body); text-decoration: none; }
        .ud-item:hover { background: var(--gray-50); color: var(--navy); }
        .ud-item i { width: 16px; font-size: 14px; color: var(--gray-500); }
        .ud-sep { height: 1px; background: var(--gray-100); margin: 6px 0; }
        .ud-logout { color: var(--red) !important; }
        .ud-logout:hover { background: rgba(215,25,32,.06) !important; }
        .ud-logout i { color: var(--red) !important; }

        /* CHATBOT BUBBLE */
        .chatbot-bubble { position: fixed; bottom: 84px; right: 28px; z-index: 999; background: var(--navy); color: white; border-radius: 50px; padding: 12px 18px; display: flex; align-items: center; gap: 8px; cursor: pointer; box-shadow: 0 6px 24px rgba(13,27,62,.25); transition: all .3s; }
        .chatbot-bubble:hover { background: var(--red); transform: translateY(-3px); box-shadow: 0 10px 32px rgba(215,25,32,.35); }
        .chatbot-bubble i { font-size: 18px; }
        .chatbot-label { font-size: 13px; font-weight: 700; white-space: nowrap; }

        /* SHARED */
        .section { padding: 72px 0; }
        .section-alt { background: var(--gray-50); }
        .container { max-width: 1240px; margin: 0 auto; padding: 0 24px; }
        .section-head { margin-bottom: 44px; }
        .section-label { display: inline-flex; align-items: center; gap: 8px; font-size: 11.5px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--red); margin-bottom: 12px; }
        .section-label::before { content: ''; width: 20px; height: 2px; background: var(--red); border-radius: 2px; }
        .section-title { font-family: var(--font-display); font-size: clamp(26px, 3.5vw, 38px); color: var(--navy); line-height: 1.25; }
        .section-desc { color: var(--gray-500); font-size: 15px; line-height: 1.7; margin-top: 12px; max-width: 560px; }
        .see-more { display: inline-flex; align-items: center; gap: 8px; color: var(--red); font-weight: 600; font-size: 14px; transition: gap .2s; }
        .see-more:hover { gap: 12px; }

        /* PARTNER */
        .partner-track { overflow: hidden; position: relative; }
        .partner-track::before, .partner-track::after { content: ''; position: absolute; top: 0; bottom: 0; width: 80px; z-index: 2; }
        .partner-track::before { left: 0; background: linear-gradient(to right, var(--gray-50), transparent); }
        .partner-track::after  { right: 0; background: linear-gradient(to left, var(--gray-50), transparent); }
        .partner-inner { display: flex; gap: 40px; animation: scroll-left 25s linear infinite; width: max-content; }
        @keyframes scroll-left { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }
        .partner-item { display: flex; align-items: center; justify-content: center; background: white; border: 1px solid var(--gray-100); border-radius: var(--radius-md); padding: 12px 24px; min-width: 130px; height: 60px; font-weight: 700; font-size: 14px; color: var(--gray-500); white-space: nowrap; }

        /* FOOTER */
        .footer { background: var(--navy); color: rgba(255,255,255,.7); padding: 56px 0 0; }
        .footer-grid { display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 40px; padding-bottom: 40px; }
        .footer-brand .logo { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }
        .footer-brand .logo-mark { width: 48px; height: 48px; border-radius: 8px; display: flex; align-items: center; justify-content: center; overflow: hidden; background: transparent; }
        .footer-brand .logo-mark img { width: 100%; height: 100%; object-fit: contain; }
        .footer-brand .logo-name { font-weight: 700; font-size: 14px; color: white; line-height: 1.3; }
        .footer-brand .logo-sub  { font-size: 10.5px; color: rgba(255,255,255,.5); }
        .footer-brand p { font-size: 13px; line-height: 1.7; margin-bottom: 16px; }
        .footer-social { display: flex; gap: 10px; }
        .footer-social a { width: 36px; height: 36px; border-radius: 8px; background: rgba(255,255,255,.08); display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,.65); font-size: 15px; transition: all .2s; }
        .footer-social a:hover { background: var(--red); color: white; }
        .footer-col h4 { color: white; font-size: 13px; font-weight: 700; margin-bottom: 16px; text-transform: uppercase; letter-spacing: .06em; }
        .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 9px; }
        .footer-col ul li a { font-size: 13px; color: rgba(255,255,255,.6); transition: color .2s; }
        .footer-col ul li a:hover { color: var(--gold-light); }
        .footer-contact-item { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 10px; font-size: 13px; }
        .footer-contact-item i { color: var(--gold); margin-top: 2px; flex-shrink: 0; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,.08); padding: 18px 0; display: flex; justify-content: space-between; align-items: center; font-size: 12.5px; }

        /* BACK TO TOP */
        #back-top { position: fixed; bottom: 28px; right: 28px; z-index: 999; width: 44px; height: 44px; background: var(--red); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 17px; cursor: pointer; box-shadow: 0 4px 16px rgba(215,25,32,.4); opacity: 0; pointer-events: none; transition: all .3s; }
        #back-top.show { opacity: 1; pointer-events: all; }
        #back-top:hover { transform: translateY(-3px); }

        /* RESPONSIVE */
        @media (max-width: 1024px) { .footer-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 768px) {
            .topbar .inner { flex-direction: column; gap: 6px; text-align: center; }
            .navbar-nav, .navbar-actions { display: none; }
            .footer-grid { grid-template-columns: 1fr; }
        }
    </style>

    @yield('styles')
    @stack('head')
</head>
<body>

{{-- TOPBAR --}}
<div class="topbar">
    <div class="inner">
        <div class="topbar-left">
            <span class="tb-info"><i class="fas fa-phone-alt"></i> Hotline: (84.8) 3850 5520</span>
            <div class="tb-divider"></div>
            <span class="tb-info"><i class="fas fa-envelope"></i> contact@stu.edu.vn</span>
        </div>
        <div class="topbar-right">
            <a href="#"><i class="fas fa-user-graduate"></i> Thí sinh</a>
            <div class="tb-divider"></div>
            <a href="#"><i class="fas fa-globe"></i> English</a>
        </div>
    </div>
</div>

{{-- NAVBAR --}}
<nav class="navbar">
    <div class="inner">

        {{-- LOGO --}}
        <a href="{{ url('/') }}" class="navbar-logo">
            <div class="logo-mark">
                <img src="{{ asset('imgs/logostu.png') }}" alt="Logo STU">
            </div>
            <div class="logo-text">
                <div class="logo-name">Đại học Công nghệ Sài Gòn</div>
                <div class="logo-sub">Saigon Technology University</div>
            </div>
        </a>

        <div class="nav-sep"></div>

        {{-- NAV LINKS --}}
        <ul class="navbar-nav">
            <li>
                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
                    Trang chủ
                </a>
            </li>

            <li class="has-dropdown">
                <a href="{{ url('/tuyen-sinh') }}"
                   class="{{ request()->is('tuyen-sinh*', 'nganh-hoc*', 'ho-so*') ? 'active' : '' }}">
                    Tuyển sinh
                    <span class="dd-arrow"><i class="fas fa-chevron-down"></i></span>
                </a>
                <ul class="dropdown">
                    <li class="dd-group-label">Thông tin chung</li>
                    <li>
                        <a href="{{ url('/tuyen-sinh') }}"
                           class="dd-item {{ request()->is('tuyen-sinh') && !request()->is('tuyen-sinh/*') ? 'active' : '' }}">
                            <span class="dd-icon"><i class="fas fa-info-circle"></i></span>
                            <span class="dd-text">
                                <span class="dd-title">Thông tin tuyển sinh</span>
                                <span class="dd-desc">Tổng quan & lịch xét tuyển 2026</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/nganh-hoc') }}"
                           class="dd-item {{ request()->is('nganh-hoc*') ? 'active' : '' }}">
                            <span class="dd-icon"><i class="fas fa-graduation-cap"></i></span>
                            <span class="dd-text">
                                <span class="dd-title">Ngành học</span>
                                <span class="dd-desc">Danh sách ngành & chỉ tiêu tuyển sinh</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/tuyen-sinh#phuong-thuc') }}" class="dd-item">
                            <span class="dd-icon"><i class="fas fa-list-check"></i></span>
                            <span class="dd-text">
                                <span class="dd-title">Phương thức xét tuyển</span>
                                <span class="dd-desc">THPT, học bạ, đánh giá năng lực…</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/tuyen-sinh#diem-chuan') }}" class="dd-item">
                            <span class="dd-icon"><i class="fas fa-chart-bar"></i></span>
                            <span class="dd-text">
                                <span class="dd-title">Điểm chuẩn</span>
                                <span class="dd-desc">Điểm chuẩn các năm trước</span>
                            </span>
                        </a>
                    </li>
                    <li class="dd-divider"></li>
                    <li>
                        <a href="{{ url('/ho-so/dang-ky') }}" class="dd-item dd-cta">
                            <span class="dd-icon"><i class="fas fa-edit"></i></span>
                            <span class="dd-text">
                                <span class="dd-title">Đăng ký xét tuyển</span>
                                <span class="dd-desc">Nộp hồ sơ trực tuyến ngay</span>
                            </span>
                            <i class="fas fa-arrow-right dd-cta-arrow"></i>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ url('/hoc-bong') }}" class="{{ request()->is('hoc-bong*') ? 'active' : '' }}">
                    Học bổng
                </a>
            </li>

            <li class="has-dropdown">
                <a href="#" class="{{ request()->is('tin-tuc*', 'su-kien*') ? 'active' : '' }}">
                    Truyền thông
                    <span class="dd-arrow"><i class="fas fa-chevron-down"></i></span>
                </a>
                <ul class="dropdown">
                    <li>
                        <a href="{{ url('/bai-viet') }}"
                           class="dd-item {{ request()->is('tin-tuc*') ? 'active' : '' }}">
                            <span class="dd-icon"><i class="fas fa-newspaper"></i></span>
                            <span class="dd-text">
                                <span class="dd-title">Bài viết</span>
                                <span class="dd-desc">Thông báo & tin tức tuyển sinh</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/su-kien') }}"
                           class="dd-item {{ request()->is('su-kien*') ? 'active' : '' }}">
                            <span class="dd-icon"><i class="fas fa-calendar-alt"></i></span>
                            <span class="dd-text">
                                <span class="dd-title">Sự kiện</span>
                                <span class="dd-desc">Ngày hội tư vấn, hội thảo mở</span>
                            </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ url('/tu-van') }}" class="{{ request()->is('tu-van*') ? 'active' : '' }}">
                    Liên hệ & Tư vấn
                </a>
            </li>
        </ul>

        {{-- ACTIONS --}}
        <div class="navbar-actions">
            @auth('thi_sinh')
                {{-- Chuông thông báo --}}
                <div class="notif-btn" id="notif-btn" title="Thông báo">
                    <i class="fas fa-bell"></i>
                    <span class="notif-badge">3</span>
                </div>

                {{-- User chip + dropdown: PHẢI bọc cùng 1 wrapper --}}
                <div class="user-chip-wrap">
                    <div class="user-chip" id="user-chip">
                        <div class="user-avatar">
                            {{ strtoupper(mb_substr(auth('thi_sinh')->user()->ho_ten, 0, 1)) }}{{ strtoupper(mb_substr(explode(' ', auth('thi_sinh')->user()->ho_ten)[1] ?? '', 0, 1)) }}
                        </div>
                        <span class="user-chip-name">{{ auth('thi_sinh')->user()->ho_ten }}</span>
                        <i class="fas fa-chevron-down user-chip-arrow" id="chip-arrow"></i>
                    </div>

                    {{-- Dropdown nằm TRONG wrapper --}}
                    <div class="user-dropdown" id="user-dropdown">
                        <div class="ud-header">
                            <div class="ud-name">{{ auth('thi_sinh')->user()->ho_ten }}</div>
                            <div class="ud-meta">
                                <span class="ud-dot"></span>
                                Thí sinh · {{ auth('thi_sinh')->user()->email }}
                            </div>
                        </div>
                        <a href="{{ url('/ho-so') }}" class="ud-item">
                            <i class="fas fa-file-alt"></i> Hồ sơ của tôi
                        </a>
                        <a href="{{ url('/hoc-bong') }}" class="ud-item">
                            <i class="fas fa-award"></i> Học bổng của tôi
                        </a>
                        <a href="{{ url('/su-kien') }}" class="ud-item">
                            <i class="fas fa-calendar-alt"></i> Sự kiện đã đăng ký
                        </a>
                        <div class="ud-sep"></div>
                        <form action="{{ route('thi-sinh.dang-xuat') }}" method="POST" style="margin:0">
                            @csrf
                            <button type="submit" class="ud-item ud-logout">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ url('/ho-so/tra-cuu') }}" class="btn-ghost">Tra cứu hồ sơ</a>
                <a href="{{ route('thi-sinh.dang-nhap') }}" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Đăng nhập
                </a>
                <a href="{{ url('/ho-so/dang-ky') }}" class="btn-primary">
                    <i class="fas fa-edit"></i> Đăng ký xét tuyển
                </a>
            @endauth
        </div>

    </div>
</nav>

{{-- CHATBOT BUBBLE --}}
<div class="chatbot-bubble" id="chatbot-bubble" title="Hỏi đáp tuyển sinh AI">
    <i class="fas fa-comments"></i>
    <span class="chatbot-label">Hỏi đáp AI</span>
</div>

@yield('content')

{{-- FOOTER --}}
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="logo">
                    <div class="logo-mark">
                        <img src="{{ asset('imgs/logostu.png') }}" alt="Logo STU">
                    </div>
                    <div>
                        <div class="logo-name">Đại học Công nghệ Sài Gòn</div>
                        <div class="logo-sub">Saigon Technology University</div>
                    </div>
                </div>
                <p>Trường đại học đa ngành, định hướng ứng dụng, tọa lạc tại TP. Hồ Chí Minh. Đào tạo nguồn nhân lực chất lượng cao cho doanh nghiệp và xã hội.</p>
                <div class="footer-social">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h4>Tuyển sinh</h4>
                <ul>
                    <li><a href="{{ url('/tuyen-sinh') }}">Thông tin tuyển sinh 2026</a></li>
                    <li><a href="{{ url('/nganh-hoc') }}">Ngành đào tạo</a></li>
                    <li><a href="{{ url('/tuyen-sinh#phuong-thuc') }}">Phương thức xét tuyển</a></li>
                    <li><a href="{{ url('/tuyen-sinh#diem-chuan') }}">Điểm chuẩn</a></li>
                    <li><a href="{{ url('/hoc-bong') }}">Học bổng & hỗ trợ</a></li>
                    <li><a href="{{ url('/ho-so/dang-ky') }}">Đăng ký xét tuyển</a></li>
                    <li><a href="{{ url('/ho-so/tra-cuu') }}">Tra cứu hồ sơ</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Nhà trường</h4>
                <ul>
                    <li><a href="#">Giới thiệu về STU</a></li>
                    <li><a href="#">Cơ cấu tổ chức</a></li>
                    <li><a href="{{ url('/bai-viet') }}">Tin tức & thông báo</a></li>
                    <li><a href="{{ url('/su-kien') }}">Sự kiện</a></li>
                    <li><a href="#">Nghiên cứu khoa học</a></li>
                    <li><a href="#">Đối tác doanh nghiệp</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Liên hệ</h4>
                <div class="footer-contact-item"><i class="fas fa-map-marker-alt"></i><span>180 Cao Lỗ, P. Chánh Hưng, Q.8, TP.HCM</span></div>
                <div class="footer-contact-item"><i class="fas fa-phone-alt"></i><span>(84.8) 3850 5520</span></div>
                <div class="footer-contact-item"><i class="fas fa-envelope"></i><span>contact@stu.edu.vn</span></div>
                <div class="footer-contact-item"><i class="fas fa-clock"></i><span>Thứ 2 – Thứ 6: 7:30 – 17:00</span></div>
            </div>
        </div>

        <div class="footer-bottom">
            <span>© {{ date('Y') }} Trường Đại học Công nghệ Sài Gòn (STU). All rights reserved.</span>
            <span>Hệ thống tuyển sinh STU</span>
        </div>
    </div>
</footer>

<div id="back-top" onclick="window.scrollTo({top:0,behavior:'smooth'})" title="Lên đầu trang">
    <i class="fas fa-arrow-up"></i>
</div>

<script>
    /* Back to top */
    const backTop = document.getElementById('back-top');
    window.addEventListener('scroll', () => {
        backTop.classList.toggle('show', window.scrollY > 400);
    });

    /* Navbar shadow on scroll */
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        navbar.style.boxShadow = window.scrollY > 10
            ? '0 4px 24px rgba(13,27,62,.12)'
            : '0 2px 16px rgba(13,27,62,.07)';
    });

    /* User chip dropdown — click để toggle */
    const userChip  = document.getElementById('user-chip');
    const userDD    = document.getElementById('user-dropdown');
    const chipArrow = document.getElementById('chip-arrow');

    if (userChip && userDD) {
        userChip.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = userDD.classList.toggle('show');
            chipArrow?.classList.toggle('open', isOpen);
        });

        /* Click ngoài thì đóng */
        document.addEventListener('click', (e) => {
            if (!userChip.closest('.user-chip-wrap').contains(e.target)) {
                userDD.classList.remove('show');
                chipArrow?.classList.remove('open');
            }
        });
    }

    /* Nav dropdown hover với delay */
    document.querySelectorAll('.has-dropdown').forEach(item => {
        const dd = item.querySelector('.dropdown');
        let timer;
        item.addEventListener('mouseenter', () => { clearTimeout(timer); dd.style.display = 'block'; });
        item.addEventListener('mouseleave', () => { timer = setTimeout(() => { dd.style.display = 'none'; }, 180); });
    });

    /* Chatbot bubble */
    document.getElementById('chatbot-bubble')?.addEventListener('click', () => {
        window.location.href = '/tu-van';
    });
</script>

@stack('scripts')
</body>
</html>