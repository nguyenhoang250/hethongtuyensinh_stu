{{-- Modules/HeThong/resources/views/auth/dang-ky.blade.php --}}
@extends('hethong::components.layouts.master')

@section('title', 'Đăng ký tài khoản — STU Tuyển Sinh')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
<style>
    :root {
        --navy:       #005B96;
        --navy-mid:   #0A6FB3;
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
        --font-display: 'Playfair Display', serif;
        --font-body:    'Be Vietnam Pro', sans-serif;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    /* ===== PAGE ===== */
    .reg-page {
        min-height: 100vh;
        background: var(--gray-100);
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 32px 16px 48px;
        font-family: var(--font-body);
    }

    /* ===== CARD ===== */
    .reg-card {
        width: 100%;
        max-width: 980px;
        display: grid;
        grid-template-columns: 300px 1fr;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(13,27,62,.16), 0 4px 16px rgba(13,27,62,.08);
        animation: cardIn .5s cubic-bezier(.22,.68,0,1.2) both;
    }
    @keyframes cardIn {
        from { opacity: 0; transform: translateY(24px) scale(.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ===== LEFT PANEL ===== */
    .reg-left {
        background: var(--navy);
        padding: 44px 32px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }
    .reg-left::before {
        content: '';
        position: absolute; top: -60px; right: -60px;
        width: 200px; height: 200px; border-radius: 50%;
        background: rgba(242,178,51,.1); pointer-events: none;
    }
    .reg-left::after {
        content: '';
        position: absolute; bottom: -50px; left: -40px;
        width: 180px; height: 180px; border-radius: 50%;
        background: rgba(215,25,32,.13); pointer-events: none;
    }
    .reg-left-deco {
        position: absolute; top: 40%; right: -40px;
        width: 110px; height: 110px; border-radius: 50%;
        border: 1px solid rgba(255,255,255,.07); pointer-events: none;
    }

    .rl-logo {
        display: flex; align-items: center; gap: 10px;
        margin-bottom: 32px; position: relative; z-index: 1;
        animation: fadeUp .5s .1s both;
    }
    .rl-logo-mark {
        width: 48px; height: 48px; background: var(--red);
        border-radius: 10px; display: flex; align-items: center; justify-content: center;
        font-family: var(--font-display); font-weight: 900; font-size: 16px;
        color: #fff; letter-spacing: -1px; flex-shrink: 0;
    }
    .rl-logo-name { font-weight: 700; font-size: 12.5px; color: #fff; line-height: 1.3; }
    .rl-logo-sub  { font-size: 10px; color: rgba(255,255,255,.4); margin-top: 1px; }

    .rl-headline {
        font-family: var(--font-display); font-size: 26px; font-weight: 900;
        color: #fff; line-height: 1.25; margin-bottom: 12px;
        position: relative; z-index: 1;
        animation: fadeUp .5s .15s both;
    }
    .rl-headline .accent { color: var(--gold-light); }

    .rl-tagline {
        font-size: 12.5px; color: rgba(255,255,255,.58);
        line-height: 1.75; margin-bottom: 28px;
        position: relative; z-index: 1;
        animation: fadeUp .5s .2s both;
    }

    /* Steps list */
    .rl-steps {
        display: flex; flex-direction: column; gap: 14px;
        position: relative; z-index: 1;
        animation: fadeUp .5s .25s both;
    }
    .rl-step {
        display: flex; align-items: flex-start; gap: 12px;
    }
    .rl-step-num {
        width: 26px; height: 26px; border-radius: 50%;
        background: rgba(255,255,255,.1);
        border: 1px solid rgba(255,255,255,.2);
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; color: var(--gold-light);
        flex-shrink: 0; margin-top: 1px;
    }
    .rl-step-text .title {
        font-size: 12.5px; font-weight: 700; color: #fff; margin-bottom: 2px;
    }
    .rl-step-text .desc {
        font-size: 11px; color: rgba(255,255,255,.45); line-height: 1.5;
    }

    /* Bottom */
    .rl-bottom { position: relative; z-index: 1; animation: fadeUp .5s .3s both; }
    .rl-badge {
        display: inline-flex; align-items: center; gap: 7px;
        background: rgba(242,178,51,.14);
        border: 1px solid rgba(242,178,51,.3);
        color: var(--gold-light);
        padding: 6px 14px; border-radius: 50px;
        font-size: 11px; font-weight: 700; letter-spacing: .06em;
        margin-bottom: 10px;
    }
    .rl-badge-dot {
        width: 6px; height: 6px; background: var(--gold); border-radius: 50%;
        animation: blink 1.5s ease-in-out infinite;
    }
    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.2} }
    .rl-hotline {
        display: flex; align-items: center; gap: 6px;
        font-size: 11px; color: rgba(255,255,255,.4);
    }
    .rl-hotline i { color: var(--gold); font-size: 12px; }

    /* ===== RIGHT PANEL ===== */
    .reg-right {
        background: var(--white);
        padding: 44px 40px;
    }

    .rr-header { margin-bottom: 24px; animation: fadeUp .5s .1s both; }
    .rr-eyebrow {
        font-size: 11px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .1em; color: var(--red);
        display: flex; align-items: center; gap: 8px; margin-bottom: 7px;
    }
    .rr-eyebrow::before {
        content: ''; display: block; width: 18px; height: 2px;
        background: var(--red); border-radius: 2px;
    }
    .rr-title {
        font-family: var(--font-display); font-size: 24px; font-weight: 700;
        color: var(--navy); line-height: 1.2; margin-bottom: 4px;
    }
    .rr-subtitle { font-size: 12.5px; color: var(--gray-500); }

    /* Progress stepper */
    .rr-progress {
        display: flex; align-items: center; gap: 0;
        margin-bottom: 28px;
        animation: fadeUp .5s .15s both;
    }
    .rp-step {
        display: flex; align-items: center; gap: 6px;
        font-size: 11.5px; font-weight: 600; color: var(--gray-500);
        flex-shrink: 0;
    }
    .rp-step.active { color: var(--navy); }
    .rp-step.done   { color: #22c55e; }
    .rp-num {
        width: 22px; height: 22px; border-radius: 50%;
        border: 1.5px solid var(--gray-300);
        display: flex; align-items: center; justify-content: center;
        font-size: 10px; font-weight: 700; color: var(--gray-500);
        transition: all .3s;
    }
    .rp-step.active .rp-num { background: var(--navy); border-color: var(--navy); color: #fff; }
    .rp-step.done   .rp-num { background: #22c55e; border-color: #22c55e; color: #fff; }
    .rp-line {
        flex: 1; height: 1.5px; background: var(--gray-100); margin: 0 8px;
    }
    .rp-line.done { background: #22c55e; }

    /* Section label */
    .rr-section {
        font-size: 10.5px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .09em; color: var(--gray-500);
        margin-bottom: 14px; padding-bottom: 8px;
        border-bottom: 1.5px solid var(--gray-100);
        display: flex; align-items: center; gap: 8px;
        animation: fadeUp .5s .2s both;
    }
    .rr-section i { color: var(--red); font-size: 13px; }

    /* Grid */
    .rr-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 6px; }
    .rr-grid.full { grid-template-columns: 1fr; }
    .rr-grid.three { grid-template-columns: 1fr 1fr 1fr; }

    /* Field */
    .rr-field { margin-bottom: 14px; animation: fadeUp .5s .2s both; }
    .rr-label {
        display: block; font-size: 12px; font-weight: 600;
        color: var(--navy); margin-bottom: 5px;
    }
    .rr-label .req { color: var(--red); }

    .rr-input-wrap { position: relative; }
    .rr-input-icon {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        color: var(--gray-500); font-size: 13px; pointer-events: none;
        transition: color .2s;
    }
    .rr-input {
        width: 100%; padding: 9px 12px 9px 36px;
        border: 1.5px solid var(--gray-300); border-radius: 8px;
        font-family: var(--font-body); font-size: 13px;
        color: var(--text); background: var(--gray-50); outline: none;
        transition: border-color .2s, background .2s, box-shadow .2s;
    }
    .rr-input:focus {
        border-color: var(--red); background: #fff;
        box-shadow: 0 0 0 3px rgba(215,25,32,.07);
    }
    .rr-input:focus + .rr-input-icon { color: var(--red); }
    .rr-input::placeholder { color: #B0BFCC; font-size: 12.5px; }
    .rr-input.is-invalid { border-color: var(--red); background: #fff9f9; }

    select.rr-input { cursor: pointer; }
    input[type=date].rr-input { cursor: pointer; }

    .rr-pw-toggle {
        position: absolute; right: 11px; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer; padding: 0;
        color: var(--gray-500); font-size: 13px; line-height: 1;
        transition: color .2s;
    }
    .rr-pw-toggle:hover { color: var(--navy); }

    .rr-error {
        font-size: 11px; color: var(--red); margin-top: 4px;
        display: flex; align-items: center; gap: 4px;
    }
    .rr-error i { font-size: 11px; }

    /* Password strength */
    .pw-strength-bar {
        display: flex; gap: 4px; margin-top: 6px;
    }
    .pw-bar-seg {
        flex: 1; height: 3px; border-radius: 2px;
        background: var(--gray-100); transition: background .3s;
    }
    .pw-strength-label {
        font-size: 10.5px; margin-top: 3px; color: var(--gray-500);
        min-height: 14px; transition: color .3s;
    }

    /* Terms checkbox */
    .rr-terms {
        display: flex; align-items: flex-start; gap: 9px;
        font-size: 12px; color: var(--gray-500); line-height: 1.6;
        margin-bottom: 20px; margin-top: 4px;
        animation: fadeUp .5s .35s both;
    }
    .rr-terms input[type=checkbox] { accent-color: var(--red); width: 14px; height: 14px; margin-top: 2px; flex-shrink: 0; }
    .rr-terms a { color: var(--navy); font-weight: 600; text-decoration: none; }
    .rr-terms a:hover { color: var(--red); text-decoration: underline; }

    /* Submit */
    .rr-submit {
        width: 100%; padding: 12px 24px;
        background: var(--red); color: #fff; border: none;
        border-radius: 50px; font-family: var(--font-body);
        font-size: 14px; font-weight: 700; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: background .2s, transform .15s, box-shadow .2s;
        box-shadow: 0 4px 16px rgba(215,25,32,.28);
        margin-bottom: 18px;
        animation: fadeUp .5s .4s both;
    }
    .rr-submit:hover {
        background: var(--red-dark); transform: translateY(-1px);
        box-shadow: 0 6px 22px rgba(215,25,32,.38);
    }
    .rr-submit:active { transform: translateY(0); }

    /* Footer link */
    .rr-footer {
        text-align: center; font-size: 12.5px; color: var(--gray-500);
        animation: fadeUp .5s .45s both;
    }
    .rr-footer a { color: var(--red); font-weight: 600; text-decoration: none; }
    .rr-footer a:hover { text-decoration: underline; }

    /* Keyframes */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 760px) {
        .reg-card { grid-template-columns: 1fr; max-width: 500px; }
        .reg-left { padding: 32px 28px; }
        .rl-steps { display: none; }
        .reg-right { padding: 32px 24px; }
        .rr-grid { grid-template-columns: 1fr; }
        .rr-grid.three { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 480px) {
        .rr-grid.three { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="reg-page">
    <div class="reg-card">

        {{-- ===== LEFT PANEL ===== --}}
        <div class="reg-left">
            <div class="reg-left-deco"></div>

            <div style="position:relative;z-index:1">
                 {{-- Logo --}}
               <a href="{{ url('/') }}" class="navbar-logo" style="display:flex; align-items:center; gap:10px; text-decoration:none;">
    <img src="{{ asset('imgs/logostu.png') }}" 
         alt="Logo STU" 
         style="height:40px; width:auto; display:block; flex-shrink:0;">
    <div style="line-height:1.3; border-left:1px solid #C7D3DF; padding-left:10px;">
        <div style="font-weight:800; font-size:13px; color:#005B96; white-space:nowrap;">ĐH Công nghệ Sài Gòn</div>
        <div style="font-size:10px; color:#708399; font-weight:500; white-space:nowrap;">Saigon Technology University</div>
    </div>
</a>
<br>

                <h2 class="rl-headline">
                    Bắt đầu hành trình<br>cùng <span class="accent">STU</span>
                </h2>
                <p class="rl-tagline">
                    Tạo tài khoản miễn phí để<br>
                    theo dõi hồ sơ & nhận thông báo<br>
                    tuyển sinh 2026.
                </p>

                {{-- Steps --}}
                <div class="rl-steps">
                    <div class="rl-step">
                        <div class="rl-step-num">1</div>
                        <div class="rl-step-text">
                            <div class="title">Điền thông tin cá nhân</div>
                            <div class="desc">Họ tên, ngày sinh, CCCD, liên hệ</div>
                        </div>
                    </div>
                    <div class="rl-step">
                        <div class="rl-step-num">2</div>
                        <div class="rl-step-text">
                            <div class="title">Tạo tài khoản & mật khẩu</div>
                            <div class="desc">Email đăng nhập & bảo mật</div>
                        </div>
                    </div>
                    <div class="rl-step">
                        <div class="rl-step-num">3</div>
                        <div class="rl-step-text">
                            <div class="title">Nộp hồ sơ xét tuyển</div>
                            <div class="desc">Chọn ngành & phương thức xét tuyển</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bottom --}}
            <div class="rl-bottom">
                <div class="rl-badge">
                    <span class="rl-badge-dot"></span>
                    Tuyển sinh 2026 đang mở
                </div>
                <div class="rl-hotline">
                    <i class="fas fa-phone-alt"></i>
                    Hotline: (84.8) 3850 5520
                </div>
            </div>
        </div>

        {{-- ===== RIGHT PANEL ===== --}}
        <div class="reg-right">

            {{-- Header --}}
            <div class="rr-header">
                <div class="rr-eyebrow">Hệ thống tuyển sinh</div>
                <h2 class="rr-title">Đăng ký tài khoản</h2>
                <p class="rr-subtitle">Dành cho thí sinh đăng ký xét tuyển STU 2026</p>
            </div>

            {{-- Progress --}}
            <div class="rr-progress">
                <div class="rp-step active">
                    <div class="rp-num">1</div>
                    <span>Cá nhân</span>
                </div>
                <div class="rp-line"></div>
                <div class="rp-step">
                    <div class="rp-num">2</div>
                    <span>Tài khoản</span>
                </div>
                <div class="rp-line"></div>
                <div class="rp-step">
                    <div class="rp-num">3</div>
                    <span>Hoàn tất</span>
                </div>
            </div>

            <form method="POST" action="{{ route('thi-sinh.dang-ky.store') }}" novalidate>
                @csrf

                {{-- SECTION 1: Thông tin cá nhân --}}
                <div class="rr-section">
                    <i class="fas fa-user"></i> Thông tin cá nhân
                </div>

                {{-- Họ và tên --}}
                <div class="rr-grid full">
                    <div class="rr-field">
                        <label class="rr-label" for="ho_ten">Họ và tên <span class="req">*</span></label>
                        <div class="rr-input-wrap">
                            <input
                                type="text" id="ho_ten" name="ho_ten"
                                value="{{ old('ho_ten') }}"
                                class="rr-input {{ $errors->has('ho_ten') ? 'is-invalid' : '' }}"
                                placeholder="Nguyễn Văn A" autocomplete="name" autofocus
                            >
                            <i class="fas fa-user rr-input-icon"></i>
                        </div>
                        @error('ho_ten')
                            <div class="rr-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Ngày sinh + Giới tính --}}
                <div class="rr-grid">
                    <div class="rr-field">
                        <label class="rr-label" for="ngay_sinh">Ngày sinh <span class="req">*</span></label>
                        <div class="rr-input-wrap">
                            <input
                                type="date" id="ngay_sinh" name="ngay_sinh"
                                value="{{ old('ngay_sinh') }}"
                                class="rr-input {{ $errors->has('ngay_sinh') ? 'is-invalid' : '' }}"
                            >
                            <i class="fas fa-calendar-alt rr-input-icon"></i>
                        </div>
                        @error('ngay_sinh')
                            <div class="rr-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="rr-field">
                        <label class="rr-label" for="gioi_tinh">Giới tính <span class="req">*</span></label>
                        <div class="rr-input-wrap">
                            <select
                                id="gioi_tinh" name="gioi_tinh"
                                class="rr-input {{ $errors->has('gioi_tinh') ? 'is-invalid' : '' }}"
                            >
                                <option value="">-- Chọn --</option>
                                <option value="nam"  {{ old('gioi_tinh') === 'nam'  ? 'selected' : '' }}>Nam</option>
                                <option value="nu"   {{ old('gioi_tinh') === 'nu'   ? 'selected' : '' }}>Nữ</option>
                                <option value="khac" {{ old('gioi_tinh') === 'khac' ? 'selected' : '' }}>Khác</option>
                            </select>
                            <i class="fas fa-venus-mars rr-input-icon"></i>
                        </div>
                        @error('gioi_tinh')
                            <div class="rr-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- CCCD + SĐT --}}
                <div class="rr-grid">
                    <div class="rr-field">
                        <label class="rr-label" for="so_cccd">Số CCCD <span class="req">*</span></label>
                        <div class="rr-input-wrap">
                            <input
                                type="text" id="so_cccd" name="so_cccd"
                                value="{{ old('so_cccd') }}"
                                class="rr-input {{ $errors->has('so_cccd') ? 'is-invalid' : '' }}"
                                placeholder="012345678901" maxlength="12"
                                inputmode="numeric"
                            >
                            <i class="fas fa-id-card rr-input-icon"></i>
                        </div>
                        @error('so_cccd')
                            <div class="rr-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="rr-field">
                        <label class="rr-label" for="so_dien_thoai">Số điện thoại <span class="req">*</span></label>
                        <div class="rr-input-wrap">
                            <input
                                type="tel" id="so_dien_thoai" name="so_dien_thoai"
                                value="{{ old('so_dien_thoai') }}"
                                class="rr-input {{ $errors->has('so_dien_thoai') ? 'is-invalid' : '' }}"
                                placeholder="0901 234 567"
                                inputmode="tel"
                            >
                            <i class="fas fa-phone-alt rr-input-icon"></i>
                        </div>
                        @error('so_dien_thoai')
                            <div class="rr-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- SECTION 2: Tài khoản --}}
                <div class="rr-section" style="margin-top:10px">
                    <i class="fas fa-lock"></i> Thông tin tài khoản
                </div>

                {{-- Email --}}
                <div class="rr-grid full">
                    <div class="rr-field">
                        <label class="rr-label" for="email">Email <span class="req">*</span></label>
                        <div class="rr-input-wrap">
                            <input
                                type="email" id="email" name="email"
                                value="{{ old('email') }}"
                                class="rr-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                placeholder="example@gmail.com" autocomplete="email"
                            >
                            <i class="fas fa-envelope rr-input-icon"></i>
                        </div>
                        @error('email')
                            <div class="rr-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Mật khẩu + Xác nhận --}}
                <div class="rr-grid">
                    <div class="rr-field">
                        <label class="rr-label" for="mat_khau">Mật khẩu <span class="req">*</span></label>
                        <div class="rr-input-wrap">
                            <input
                                type="password" id="mat_khau" name="mat_khau"
                                class="rr-input {{ $errors->has('mat_khau') ? 'is-invalid' : '' }}"
                                placeholder="••••••••" autocomplete="new-password"
                                style="padding-right:36px"
                            >
                            <i class="fas fa-key rr-input-icon"></i>
                            <button type="button" class="rr-pw-toggle" id="pw-toggle1" aria-label="Hiện/ẩn mật khẩu">
                                <i class="fas fa-eye" id="pw-eye1"></i>
                            </button>
                        </div>
                        {{-- Password strength --}}
                        <div class="pw-strength-bar" id="pw-bars">
                            <div class="pw-bar-seg" id="bar1"></div>
                            <div class="pw-bar-seg" id="bar2"></div>
                            <div class="pw-bar-seg" id="bar3"></div>
                            <div class="pw-bar-seg" id="bar4"></div>
                        </div>
                        <div class="pw-strength-label" id="pw-label"></div>
                        @error('mat_khau')
                            <div class="rr-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="rr-field">
                        <label class="rr-label" for="mat_khau_confirmation">Xác nhận mật khẩu <span class="req">*</span></label>
                        <div class="rr-input-wrap">
                            <input
                                type="password" id="mat_khau_confirmation" name="mat_khau_confirmation"
                                class="rr-input" placeholder="••••••••"
                                autocomplete="new-password"
                                style="padding-right:36px"
                            >
                            <i class="fas fa-shield-alt rr-input-icon"></i>
                            <button type="button" class="rr-pw-toggle" id="pw-toggle2" aria-label="Hiện/ẩn mật khẩu">
                                <i class="fas fa-eye" id="pw-eye2"></i>
                            </button>
                        </div>
                        <div class="pw-strength-label" id="pw-match-label"></div>
                    </div>
                </div>

                {{-- Terms --}}
                <div class="rr-terms">
                    <input type="checkbox" name="dong_y_dieu_khoan" id="terms" required>
                    <label for="terms">
                        Tôi đã đọc và đồng ý với
                        <a href="#" target="_blank">Điều khoản sử dụng</a>
                        và
                        <a href="#" target="_blank">Chính sách bảo mật</a>
                        của STU.
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="rr-submit">
                    <i class="fas fa-user-plus"></i>
                    Tạo tài khoản
                </button>

                {{-- Footer --}}
                <div class="rr-footer">
                    Đã có tài khoản?
                    <a href="{{ route('thi-sinh.dang-nhap') }}">Đăng nhập ngay</a>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    // === Toggle password 1 ===
    function togglePw(fieldId, eyeId) {
        const f = document.getElementById(fieldId);
        const e = document.getElementById(eyeId);
        if (!f) return;
        const hidden = f.type === 'password';
        f.type = hidden ? 'text' : 'password';
        e.className = hidden ? 'fas fa-eye-slash' : 'fas fa-eye';
    }
    document.getElementById('pw-toggle1').addEventListener('click', () => togglePw('mat_khau', 'pw-eye1'));
    document.getElementById('pw-toggle2').addEventListener('click', () => togglePw('mat_khau_confirmation', 'pw-eye2'));

    // === Icon color on focus ===
    document.querySelectorAll('.rr-input').forEach(function(input) {
        input.addEventListener('focus', function() {
            const icon = this.parentElement.querySelector('.rr-input-icon');
            if (icon) icon.style.color = 'var(--red)';
        });
        input.addEventListener('blur', function() {
            const icon = this.parentElement.querySelector('.rr-input-icon');
            if (icon) icon.style.color = 'var(--gray-500)';
        });
    });

    // === Password strength ===
    const pwInput  = document.getElementById('mat_khau');
    const pwLabel  = document.getElementById('pw-label');
    const bars     = [
        document.getElementById('bar1'),
        document.getElementById('bar2'),
        document.getElementById('bar3'),
        document.getElementById('bar4'),
    ];
    const colors   = ['#E24B4A','#F2B233','#22c55e','#15803d'];
    const labels   = ['Yếu','Trung bình','Mạnh','Rất mạnh'];

    function calcStrength(pw) {
        let score = 0;
        if (pw.length >= 8)  score++;
        if (/[A-Z]/.test(pw)) score++;
        if (/[0-9]/.test(pw)) score++;
        if (/[^A-Za-z0-9]/.test(pw)) score++;
        return score;
    }

    pwInput.addEventListener('input', function() {
        const val = this.value;
        const score = val.length === 0 ? 0 : calcStrength(val);
        bars.forEach((b, i) => {
            b.style.background = i < score ? colors[score - 1] : 'var(--gray-100)';
        });
        pwLabel.textContent = val.length === 0 ? '' : labels[score - 1] || '';
        pwLabel.style.color  = val.length === 0 ? '' : colors[score - 1];
        checkMatch();
    });

    // === Password match ===
    const pw2      = document.getElementById('mat_khau_confirmation');
    const matchLbl = document.getElementById('pw-match-label');

    function checkMatch() {
        if (!pw2.value) { matchLbl.textContent = ''; return; }
        if (pw2.value === pwInput.value) {
            matchLbl.textContent = '✓ Mật khẩu khớp';
            matchLbl.style.color = '#22c55e';
            pw2.style.borderColor = '#22c55e';
        } else {
            matchLbl.textContent = '✗ Mật khẩu chưa khớp';
            matchLbl.style.color = 'var(--red)';
            pw2.style.borderColor = 'var(--red)';
        }
    }
    pw2.addEventListener('input', checkMatch);

    // === CCCD: chỉ nhập số ===
    document.getElementById('so_cccd').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 12);
    });
</script>
@endpush