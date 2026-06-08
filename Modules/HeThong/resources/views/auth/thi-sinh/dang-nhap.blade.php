{{-- Modules/HeThong/resources/views/auth/dang-nhap.blade.php --}}
@extends('hethong::components.layouts.master')

@section('title', 'Đăng nhập — STU Tuyển Sinh')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
<style>
    :root {
        --navy:       #005B96;
        --navy-mid:   #0A6FB3;
        --blue-dark:  #083A84;
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
    html { scroll-behavior: smooth; }

    /* ===== PAGE WRAPPER ===== */
    .login-page {
        min-height: 100vh;
        background: var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 32px 16px;
        font-family: var(--font-body);
    }

    /* ===== CARD ===== */
    .login-card {
        width: 100%;
        max-width: 920px;
        display: grid;
        grid-template-columns: 1fr 1fr;
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
    .login-left {
        background: var(--navy);
        padding: 48px 40px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }
    .login-left::before {
        content: '';
        position: absolute; top: -70px; right: -70px;
        width: 240px; height: 240px;
        border-radius: 50%;
        background: rgba(242,178,51,.11);
        pointer-events: none;
    }
    .login-left::after {
        content: '';
        position: absolute; bottom: -50px; left: -50px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(215,25,32,.14);
        pointer-events: none;
    }
    .login-left-deco {
        position: absolute; bottom: 90px; right: -30px;
        width: 120px; height: 120px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,.06);
        pointer-events: none;
    }

    /* Logo */
    .ll-logo {
        display: flex; align-items: center; gap: 12px;
        margin-bottom: 36px;
        position: relative; z-index: 1;
        animation: fadeUp .5s .1s both;
    }
    .ll-logo-mark {
        width: 52px; height: 52px;
        background: var(--red);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-family: var(--font-display); font-weight: 900; font-size: 18px;
        color: #fff; letter-spacing: -1px; flex-shrink: 0;
    }
    .ll-logo-name { font-weight: 700; font-size: 13px; color: #fff; line-height: 1.3; }
    .ll-logo-sub  { font-size: 10.5px; color: rgba(255,255,255,.45); margin-top: 1px; }

    /* Headline */
    .ll-headline {
        font-family: var(--font-display);
        font-size: 30px; font-weight: 900;
        color: #fff; line-height: 1.22;
        margin-bottom: 14px;
        position: relative; z-index: 1;
        animation: fadeUp .5s .15s both;
    }
    .ll-headline .accent { color: var(--gold-light); }

    .ll-tagline {
        font-size: 13px; color: rgba(255,255,255,.6);
        line-height: 1.75; margin-bottom: 32px;
        position: relative; z-index: 1;
        animation: fadeUp .5s .2s both;
    }

    /* Stats */
    .ll-stats {
        display: flex; gap: 0;
        position: relative; z-index: 1;
        animation: fadeUp .5s .25s both;
    }
    .ll-stat {
        flex: 1; text-align: center; padding: 0 10px;
        border-right: 1px solid rgba(255,255,255,.1);
    }
    .ll-stat:last-child { border-right: none; }
    .ll-stat .num {
        font-family: var(--font-display); font-size: 24px; font-weight: 700;
        color: var(--gold); line-height: 1;
    }
    .ll-stat .lbl {
        font-size: 10px; color: rgba(255,255,255,.45);
        text-transform: uppercase; letter-spacing: .06em; margin-top: 4px;
    }

    /* Bottom badge */
    .ll-bottom { position: relative; z-index: 1; animation: fadeUp .5s .3s both; }
    .ll-badge {
        display: inline-flex; align-items: center; gap: 7px;
        background: rgba(242,178,51,.14);
        border: 1px solid rgba(242,178,51,.3);
        color: var(--gold-light);
        padding: 6px 14px; border-radius: 50px;
        font-size: 11.5px; font-weight: 700; letter-spacing: .06em;
        margin-bottom: 10px;
    }
    .ll-badge-dot {
        width: 6px; height: 6px;
        background: var(--gold); border-radius: 50%;
        animation: blink 1.5s ease-in-out infinite;
    }
    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.2} }
    .ll-hotline {
        display: flex; align-items: center; gap: 6px;
        font-size: 11.5px; color: rgba(255,255,255,.45);
    }
    .ll-hotline i { color: var(--gold); font-size: 13px; }

    /* ===== RIGHT PANEL ===== */
    .login-right {
        background: var(--white);
        padding: 48px 40px;
        display: flex; flex-direction: column; justify-content: center;
    }

    .lr-header { margin-bottom: 28px; animation: fadeUp .5s .1s both; }
    .lr-eyebrow {
        font-size: 11px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .1em; color: var(--red);
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 8px;
    }
    .lr-eyebrow::before {
        content: ''; display: block; width: 18px; height: 2px;
        background: var(--red); border-radius: 2px;
    }
    .lr-title {
        font-family: var(--font-display); font-size: 26px; font-weight: 700;
        color: var(--navy); line-height: 1.2; margin-bottom: 4px;
    }
    .lr-subtitle { font-size: 13px; color: var(--gray-500); }

    /* Alert */
    .lr-alert {
        background: var(--gray-100);
        border-left: 3px solid var(--navy);
        border-radius: 6px;
        padding: 10px 14px;
        font-size: 12.5px; color: var(--navy);
        margin-bottom: 22px;
        display: flex; align-items: center; gap: 8px;
        animation: fadeUp .5s .15s both;
    }
    .lr-alert i { font-size: 15px; flex-shrink: 0; }

    /* Status message (Laravel session) */
    .lr-status {
        background: #EAF7ED;
        border-left: 3px solid #22c55e;
        border-radius: 6px;
        padding: 10px 14px;
        font-size: 12.5px; color: #166534;
        margin-bottom: 18px;
        display: flex; align-items: center; gap: 8px;
    }

    /* Field */
    .lr-field { margin-bottom: 16px; animation: fadeUp .5s .2s both; }
    .lr-field + .lr-field { animation-delay: .25s; }
    .lr-label {
        display: block; font-size: 12.5px; font-weight: 600;
        color: var(--navy); margin-bottom: 6px;
    }
    .lr-label .req { color: var(--red); }

    .lr-input-wrap { position: relative; }
    .lr-input-icon {
        position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
        color: var(--gray-500); font-size: 15px; pointer-events: none;
        transition: color .2s;
    }
    .lr-input {
        width: 100%; padding: 10px 14px 10px 40px;
        border: 1.5px solid var(--gray-300);
        border-radius: 8px;
        font-family: var(--font-body); font-size: 13.5px;
        color: var(--text); background: var(--gray-50);
        outline: none; transition: border-color .2s, background .2s, box-shadow .2s;
    }
    .lr-input:focus {
        border-color: var(--red); background: #fff;
        box-shadow: 0 0 0 3px rgba(215,25,32,.08);
    }
    .lr-input:focus ~ .lr-input-icon { color: var(--red); }
    .lr-input::placeholder { color: #B0BFCC; }
    .lr-input.is-invalid { border-color: var(--red); background: #fff9f9; }

    .lr-pw-toggle {
        position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: var(--gray-500); font-size: 15px; padding: 0; line-height: 1;
        transition: color .2s;
    }
    .lr-pw-toggle:hover { color: var(--navy); }

    .lr-error {
        font-size: 11.5px; color: var(--red); margin-top: 5px;
        display: flex; align-items: center; gap: 5px;
    }
    .lr-error i { font-size: 12px; }

    /* Remember + forgot row */
    .lr-row {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 22px; animation: fadeUp .5s .3s both;
    }
    .lr-remember {
        display: flex; align-items: center; gap: 7px;
        font-size: 12.5px; color: var(--gray-500); cursor: pointer;
    }
    .lr-remember input[type=checkbox] { accent-color: var(--red); width: 14px; height: 14px; }
    .lr-forgot {
        font-size: 12.5px; font-weight: 600; color: var(--navy);
        background: none; border: none; cursor: pointer; padding: 0;
        font-family: var(--font-body); transition: color .2s;
    }
    .lr-forgot:hover { color: var(--red); text-decoration: underline; }

    /* Submit button */
    .lr-submit {
        width: 100%; padding: 12px 24px;
        background: var(--red); color: #fff; border: none;
        border-radius: 50px;
        font-family: var(--font-body); font-size: 14px; font-weight: 700;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: background .2s, transform .15s, box-shadow .2s;
        box-shadow: 0 4px 16px rgba(215,25,32,.28);
        margin-bottom: 18px;
        animation: fadeUp .5s .35s both;
    }
    .lr-submit:hover {
        background: var(--red-dark); transform: translateY(-1px);
        box-shadow: 0 6px 22px rgba(215,25,32,.38);
    }
    .lr-submit:active { transform: translateY(0); }

    /* Divider */
    .lr-divider {
        display: flex; align-items: center; gap: 12px;
        margin-bottom: 16px; animation: fadeUp .5s .4s both;
    }
    .lr-divider-line { flex: 1; height: 1px; background: var(--gray-100); }
    .lr-divider-text { font-size: 11.5px; color: var(--gray-500); white-space: nowrap; }

    /* Footer */
    .lr-footer {
        text-align: center; font-size: 12.5px; color: var(--gray-500);
        animation: fadeUp .5s .45s both;
    }
    .lr-footer a { color: var(--red); font-weight: 600; text-decoration: none; }
    .lr-footer a:hover { text-decoration: underline; }

    /* Keyframes */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 680px) {
        .login-card { grid-template-columns: 1fr; max-width: 420px; }
        .login-left { padding: 32px 28px; }
        .ll-stats { display: none; }
        .ll-headline { font-size: 24px; }
        .login-right { padding: 32px 28px; }
    }
</style>
@endsection

@section('content')
<div class="login-page">
    <div class="login-card">

        {{-- ===== LEFT PANEL ===== --}}
        <div class="login-left">
            <div class="login-left-deco"></div>

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
                {{-- Headline --}}
                <h1 class="ll-headline">
                    Kiến tạo<br>tương lai cùng<br><span class="accent">STU 2026</span>
                </h1>
                <p class="ll-tagline">
                    3.000 chỉ tiêu — 18 ngành học.<br>
                    Học bổng lên đến 100% học phí<br>dành cho tân sinh viên xuất sắc.
                </p>

                {{-- Stats --}}
                <div class="ll-stats">
                    <div class="ll-stat">
                        <div class="num">30+</div>
                        <div class="lbl">Năm đào tạo</div>
                    </div>
                    <div class="ll-stat">
                        <div class="num">96%</div>
                        <div class="lbl">Có việc làm</div>
                    </div>
                    <div class="ll-stat">
                        <div class="num">11k+</div>
                        <div class="lbl">Sinh viên</div>
                    </div>
                </div>
            </div>

            {{-- Bottom badge --}}
            <div class="ll-bottom">
                <div class="ll-badge">
                    <span class="ll-badge-dot"></span>
                    Tuyển sinh 2026 đang mở
                </div>
                <div class="ll-hotline">
                    <i class="fas fa-phone-alt"></i>
                    Hotline: (84.8) 3850 5520
                </div>
            </div>
        </div>

        {{-- ===== RIGHT PANEL ===== --}}
        <div class="login-right">

            {{-- Header --}}
            <div class="lr-header">
                <div class="lr-eyebrow">Hệ thống tuyển sinh</div>
                <h2 class="lr-title">Đăng nhập</h2>
                <p class="lr-subtitle">Chào mừng bạn — vui lòng nhập thông tin để tiếp tục</p>
            </div>

            {{-- Session status --}}
            @if(session('status'))
                <div class="lr-status">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Info alert --}}
            <div class="lr-alert">
                <i class="fas fa-info-circle"></i>
                Dùng tài khoản đã đăng ký trên cổng xét tuyển STU
            </div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('thi-sinh.dang-nhap') }}" novalidate>
                @csrf

                {{-- Email --}}
                <div class="lr-field">
                    <label class="lr-label" for="email">
                        Email <span class="req">*</span>
                    </label>
                    <div class="lr-input-wrap">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="lr-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            
                            autocomplete="email"
                            autofocus
                        >
                        <i class="fas fa-envelope lr-input-icon"></i>
                    </div>
                    @error('email')
                        <div class="lr-error">
                            <i class="fas fa-exclamation-circle"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="lr-field">
                    <label class="lr-label" for="mat_khau">
                        Mật khẩu <span class="req">*</span>
                    </label>
                    <div class="lr-input-wrap">
                        <input
                            type="password"
                            id="mat_khau"
                            name="mat_khau"
                            class="lr-input {{ $errors->has('mat_khau') ? 'is-invalid' : '' }}"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            style="padding-right:40px"
                        >
                        <i class="fas fa-lock lr-input-icon"></i>
                        <button type="button" class="lr-pw-toggle" id="pw-toggle" aria-label="Hiện/ẩn mật khẩu">
                            <i class="fas fa-eye" id="pw-eye"></i>
                        </button>
                    </div>
                    @error('mat_khau')
                        <div class="lr-error">
                            <i class="fas fa-exclamation-circle"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Remember + Forgot --}}
                <div class="lr-row">
                    <label class="lr-remember">
                        <input type="checkbox" name="nho_toi" {{ old('nho_toi') ? 'checked' : '' }}>
                        Nhớ đăng nhập
                    </label>
                    <a href="{{ route('admin.quen-mat-khau') }}" class="lr-forgot">Quên mật khẩu?</a>
                </div>

                {{-- Submit --}}
                <button type="submit" class="lr-submit">
                    <i class="fas fa-sign-in-alt"></i>
                    Đăng nhập
                </button>

                {{-- Divider --}}
                <div class="lr-divider">
                    <div class="lr-divider-line"></div>
                    <span class="lr-divider-text">hoặc</span>
                    <div class="lr-divider-line"></div>
                </div>

                {{-- Register link --}}
                <div class="lr-footer">
                    Chưa có tài khoản?
                    <a href="{{ route('thi-sinh.dang-ky') }}">Đăng ký ngay</a>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle show/hide password
    const pwToggle = document.getElementById('pw-toggle');
    const pwField  = document.getElementById('mat_khau');
    const pwEye    = document.getElementById('pw-eye');

    if (pwToggle) {
        pwToggle.addEventListener('click', function () {
            const isHidden = pwField.type === 'password';
            pwField.type = isHidden ? 'text' : 'password';
            pwEye.className = isHidden ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
    }

    // Icon color on input focus (since :focus-within not supported on sibling)
    document.querySelectorAll('.lr-input').forEach(function(input) {
        input.addEventListener('focus', function() {
            const icon = this.parentElement.querySelector('.lr-input-icon');
            if (icon) icon.style.color = 'var(--red)';
        });
        input.addEventListener('blur', function() {
            const icon = this.parentElement.querySelector('.lr-input-icon');
            if (icon) icon.style.color = 'var(--gray-500)';
        });
    });
</script>
@endpush