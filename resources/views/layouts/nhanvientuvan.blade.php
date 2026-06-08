@extends('layouts.admin')

@section('title', 'Trang tư vấn viên')
@section('page_title', 'Dashboard Tư Vấn Viên')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-headset mr-2"></i>
                    Xin chào, {{ Auth::guard('nhan_vien_tu_van')->user()->ma_nhan_vien }}!
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fas fa-comments"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Yêu cầu tư vấn</span>
                                <span class="info-box-number">0</span>
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
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle"></i>
                    Module tư vấn đang được xây dựng. Sẽ cập nhật sớm!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection