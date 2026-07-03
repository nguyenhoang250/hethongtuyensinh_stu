@extends('layouts.admin')

@section('title', 'Thêm CTDT')
@section('page_title', 'Thêm Chương Trình Đào Tạo')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm Chương Trình Đào Tạo</h3>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ route('admin.chuong-trinh-dao-tao.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Ngành Học <span class="text-danger">*</span></label>
                <select name="nganh_hoc_id" class="form-control">
                    <option value="">-- Chọn ngành --</option>
                    @foreach($nganhHocs as $nganh)
                        <option value="{{ $nganh->id }}" {{ old('nganh_hoc_id') == $nganh->id ? 'selected' : '' }}>
                            {{ $nganh->ten_nganh }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Năm Ban Hành <span class="text-danger">*</span></label>
                        <input type="number" name="nam_ban_hanh" class="form-control" value="{{ old('nam_ban_hanh', date('Y')) }}" min="2000" max="2099">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tổng Tín Chỉ <span class="text-danger">*</span></label>
                        <input type="number" name="tong_tin_chi" class="form-control" value="{{ old('tong_tin_chi') }}" min="1">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>File PDF <span class="text-danger">*</span></label>
                <input type="file" name="file_ctdt" class="form-control-file" accept=".pdf">
                <small class="text-muted">Chỉ chấp nhận file PDF, tối đa 10MB</small>
            </div>
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_hien_thi" name="is_hien_thi" value="1" checked>
                    <label class="custom-control-label" for="is_hien_thi">Hiển thị</label>
                </div>
            </div>
            <a href="{{ route('admin.chuong-trinh-dao-tao.index') }}" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>
</div>
@endsection