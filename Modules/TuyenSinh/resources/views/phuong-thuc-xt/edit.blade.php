@extends('layouts.admin')
@section('title', 'Sửa Phương Thức Xét Tuyển')
@section('page_title', 'Sửa Phương Thức Xét Tuyển')
@section('content')
<div class="card">
    <div class="card-header"><h3 class="card-title">Sửa: {{ $phuongThuc->ten_phuong_thuc }}</h3></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ route('admin.phuong-thuc-xt.update', $phuongThuc->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Mã Phương Thức <span class="text-danger">*</span></label>
                <input type="text" name="ma_phuong_thuc" class="form-control" value="{{ old('ma_phuong_thuc', $phuongThuc->ma_phuong_thuc) }}">
            </div>
            <div class="form-group">
                <label>Tên Phương Thức <span class="text-danger">*</span></label>
                <input type="text" name="ten_phuong_thuc" class="form-control" value="{{ old('ten_phuong_thuc', $phuongThuc->ten_phuong_thuc) }}">
            </div>
            <div class="form-group">
                <label>Mô tả</label>
                <textarea name="mo_ta" class="form-control" rows="3">{{ old('mo_ta', $phuongThuc->mo_ta) }}</textarea>
            </div>
            <div class="form-group">
                <label>Loại điểm <span class="text-danger">*</span></label>
                <select name="loai_diem" class="form-control">
                    <option value="hoc_ba" {{ old('loai_diem', $phuongThuc->loai_diem) == 'hoc_ba' ? 'selected' : '' }}>Học bạ</option>
                    <option value="thi_thpt" {{ old('loai_diem', $phuongThuc->loai_diem) == 'thi_thpt' ? 'selected' : '' }}>Thi THPT</option>
                    <option value="danh_gia_nang_luc" {{ old('loai_diem', $phuongThuc->loai_diem) == 'danh_gia_nang_luc' ? 'selected' : '' }}>Đánh giá năng lực</option>
                </select>
            </div>
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                        {{ old('is_active', $phuongThuc->is_active) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_active">Đang hoạt động</label>
                </div>
            </div>
            <a href="{{ route('admin.phuong-thuc-xt.index') }}" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-warning">Cập nhật</button>
        </form>
    </div>
</div>
@endsection