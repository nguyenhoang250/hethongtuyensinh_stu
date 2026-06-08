@extends('layouts.admin')

@section('title', 'Dashboard Tư Vấn Viên')
@section('page_title', 'Tổng quan')

@section('content')
@php
    $user   = Auth::guard('admin')->user();
    $nvtv   = $user->nhanVienTuVan;
@endphp

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-headset mr-2"></i>
                    Xin chào, {{ $user->ho_ten }}!
                    @if($nvtv)
                        <small class="text-muted ml-2">({{ $nvtv->ma_nhan_vien }} — {{ $nvtv->phong_ban }})</small>
                    @endif
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fas fa-comments"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Yêu cầu tư vấn</span>
                                <span class="info-box-number">{{ $nvtv->so_luong_tu_van ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Chờ xử lý</span>
                                <span class="info-box-number">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Đã xử lý</span>
                                <span class="info-box-number">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($nvtv)
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-id-badge mr-1"></i> Thông tin của tôi
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td class="text-muted pl-3" style="width:40%">Mã nhân viên</td>
                                        <td><strong>{{ $nvtv->ma_nhan_vien }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted pl-3">Phòng ban</td>
                                        <td>{{ $nvtv->phong_ban }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted pl-3">Chuyên môn</td>
                                        <td>{{ $nvtv->chuyen_mon ?? '—' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted pl-3">Email</td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted pl-3">Số điện thoại</td>
                                        <td>{{ $user->so_dien_thoai ?? '—' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Module tư vấn đang được xây dựng. Sẽ cập nhật sớm!
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection