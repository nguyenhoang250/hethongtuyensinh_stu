<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Hệ Thống Tuyển Sinh STU')</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    @php
        $user    = Auth::guard('admin')->user();
        $isNVTV  = $user && $user->laNhanVienTuVan();
    @endphp

    {{-- Navbar --}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                    <i class="fas fa-user-circle"></i>
                    <span class="ml-1">{{ $user->ho_ten ?? 'Admin' }}</span>
                    @if($isNVTV)
                        <span class="badge badge-info ml-1">Tư vấn viên</span>
                    @else
                        <span class="badge badge-danger ml-1">Admin</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-item-text">
                        <small class="text-muted">{{ $user->email ?? '' }}</small>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> Hồ sơ
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item text-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
                    </a>
                    <form id="logout-form" action="{{ route('admin.dang-xuat') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    {{-- Sidebar --}}
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ $isNVTV ? route('admin.tu-van.dashboard') : route('admin.dashboard') }}" class="brand-link">
            <img src="{{ asset('imgs/logostu.png') }}" alt="STU" class="brand-image img-circle elevation-3" style="opacity:.8">
            <span class="brand-text font-weight-bold">STU Tuyển Sinh</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                    @if(!$isNVTV)
                    {{-- ===== ADMIN: full menu ===== --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Tổng quan</p>
                        </a>
                    </li>

                    <li class="nav-header">HỆ THỐNG</li>

                   

                   

                    <li class="nav-item has-treeview {{ request()->routeIs('admin.quan-ly.*') || request()->routeIs('admin.thi-sinh.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.quan-ly.*') || request()->routeIs('admin.thi-sinh.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Quản lý người dùng <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.quan-ly.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.quan-ly.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Admin & Nhân viên tư vấn</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.thi-sinh.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.thi-sinh.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Thí sinh</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    @else
                    {{-- ===== NVTV: menu giới hạn ===== --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.tu-van.dashboard') }}"
                            class="nav-link {{ request()->routeIs('admin.tu-van.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Tổng quan</p>
                        </a>
                    </li>

                    <li class="nav-header">TƯ VẤN</li>

                    <li class="nav-item">
                        <a href="#" class="nav-link disabled">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>Yêu cầu tư vấn <small class="text-warning">(chưa có)</small></p>
                        </a>
                    </li>
                    @endif

                </ul>
            </nav>
        </div>
    </aside>

    {{-- Content --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page_title', 'Tổng quan')</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <strong>STU Tuyển Sinh</strong> &copy; {{ date('Y') }}
        <div class="float-right d-none d-sm-inline-block">
            <b>Xin chào,</b> {{ $user->ho_ten ?? 'Admin' }}
        </div>
    </footer>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
@stack('scripts')
</body>
</html>