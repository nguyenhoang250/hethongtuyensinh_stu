@extends('layouts.admin')

@section('title', 'Thêm Khoa')
@section('page_title', 'Thêm Khoa mới')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm Khoa mới</h3>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ route('admin.khoa.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Mã Khoa <span class="text-danger">*</span></label>
                <input type="text" name="ma_khoa" class="form-control" value="{{ old('ma_khoa') }}" placeholder="VD: CNTT">
            </div>
            <div class="form-group">
                <label>Tên Khoa <span class="text-danger">*</span></label>
                <input type="text" name="ten_khoa" class="form-control" value="{{ old('ten_khoa') }}" placeholder="VD: Khoa Công nghệ Thông tin">
            </div>
            <div class="form-group">
                <label>Trưởng Khoa</label>
                <input type="text" name="truong_khoa" class="form-control" value="{{ old('truong_khoa') }}">
            </div>
            <div class="form-group">
                <label>Email Khoa</label>
                <input type="email" name="email_khoa" class="form-control" value="{{ old('email_khoa') }}">
            </div>
            <div class="form-group">
                <label>Mô tả</label>
                <textarea name="mo_ta" class="form-control" rows="3">{{ old('mo_ta') }}</textarea>
            </div>
            <div class="form-group">
                <label>Thứ tự hiển thị</label>
                <input type="number" name="thu_tu" class="form-control" value="{{ old('thu_tu', 0) }}" min="0">
            </div>
            <a href="{{ route('admin.khoa.index') }}" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>
</div>
@endsection