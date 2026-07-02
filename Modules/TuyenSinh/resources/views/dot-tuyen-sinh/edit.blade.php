@extends('layouts.admin')
@section('title', 'Sửa Đợt Tuyển Sinh')
@section('page_title', 'Sửa Đợt Tuyển Sinh')
@section('content')
<div class="card">
    <div class="card-header"><h3 class="card-title">Sửa: {{ $dot->ten_dot }}</h3></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ route('admin.dot-tuyen-sinh.update', $dot->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Mã Đợt <span class="text-danger">*</span></label>
                        <input type="text" name="ma_dot" class="form-control" value="{{ old('ma_dot', $dot->ma_dot) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Năm Học <span class="text-danger">*</span></label>
                        <input type="text" name="nam_hoc" class="form-control" value="{{ old('nam_hoc', $dot->nam_hoc) }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Tên Đợt <span class="text-danger">*</span></label>
                <input type="text" name="ten_dot" class="form-control" value="{{ old('ten_dot', $dot->ten_dot) }}">
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Ngày bắt đầu <span class="text-danger">*</span></label>
                        <input type="date" name="ngay_bat_dau" class="form-control" value="{{ old('ngay_bat_dau', $dot->ngay_bat_dau) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Ngày kết thúc <span class="text-danger">*</span></label>
                        <input type="date" name="ngay_ket_thuc" class="form-control" value="{{ old('ngay_ket_thuc', $dot->ngay_ket_thuc) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Ngày công bố KQ</label>
                        <input type="date" name="ngay_cong_bo" class="form-control" value="{{ old('ngay_cong_bo', $dot->ngay_cong_bo) }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Trạng thái <span class="text-danger">*</span></label>
                <select name="trang_thai" class="form-control">
                    <option value="chuan_bi" {{ old('trang_thai', $dot->trang_thai) == 'chuan_bi' ? 'selected' : '' }}>Chuẩn bị</option>
                    <option value="dang_mo" {{ old('trang_thai', $dot->trang_thai) == 'dang_mo' ? 'selected' : '' }}>Đang mở</option>
                    <option value="da_dong" {{ old('trang_thai', $dot->trang_thai) == 'da_dong' ? 'selected' : '' }}>Đã đóng</option>
                    <option value="da_cong_bo" {{ old('trang_thai', $dot->trang_thai) == 'da_cong_bo' ? 'selected' : '' }}>Đã công bố</option>
                </select>
            </div>
            <div class="form-group">
                <label>Ghi chú</label>
                <textarea name="ghi_chu" class="form-control" rows="2">{{ old('ghi_chu', $dot->ghi_chu) }}</textarea>
            </div>
            <a href="{{ route('admin.dot-tuyen-sinh.index') }}" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-warning">Cập nhật</button>
        </form>
    </div>
</div>
@endsection