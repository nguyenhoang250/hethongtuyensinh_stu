@extends('layouts.admin')

@section('title', 'Sửa Ngành Học')
@section('page_title', 'Sửa Ngành Học')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sửa Ngành: {{ $nganhHoc->ten_nganh }}</h3>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ route('admin.nganh-hoc.update', $nganhHoc->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Khoa <span class="text-danger">*</span></label>
                <select name="khoa_id" class="form-control">
                    <option value="">-- Chọn khoa --</option>
                    @foreach($khoas as $khoa)
                        <option value="{{ $khoa->id }}" {{ old('khoa_id', $nganhHoc->khoa_id) == $khoa->id ? 'selected' : '' }}>
                            {{ $khoa->ten_khoa }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Mã Ngành <span class="text-danger">*</span></label>
                <input type="text" name="ma_nganh" class="form-control" value="{{ old('ma_nganh', $nganhHoc->ma_nganh) }}">
            </div>
            <div class="form-group">
                <label>Tên Ngành (Tiếng Việt) <span class="text-danger">*</span></label>
                <input type="text" name="ten_nganh" class="form-control" value="{{ old('ten_nganh', $nganhHoc->ten_nganh) }}">
            </div>
            <div class="form-group">
                <label>Tên Ngành (Tiếng Anh)</label>
                <input type="text" name="ten_nganh_en" class="form-control" value="{{ old('ten_nganh_en', $nganhHoc->ten_nganh_en) }}">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Trình độ <span class="text-danger">*</span></label>
                        <select name="trinh_do" class="form-control">
                            <option value="dai_hoc" {{ old('trinh_do', $nganhHoc->trinh_do) == 'dai_hoc' ? 'selected' : '' }}>Đại học</option>
                            <option value="lien_thong" {{ old('trinh_do', $nganhHoc->trinh_do) == 'lien_thong' ? 'selected' : '' }}>Liên thông</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Thời gian đào tạo (năm) <span class="text-danger">*</span></label>
                        <input type="number" name="thoi_gian_dao_tao" class="form-control" value="{{ old('thoi_gian_dao_tao', $nganhHoc->thoi_gian_dao_tao) }}" min="1" max="6">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Mô tả</label>
                <textarea name="mo_ta" class="form-control" rows="3">{{ old('mo_ta', $nganhHoc->mo_ta) }}</textarea>
            </div>
            <div class="form-group">
                <label>Chuẩn đầu ra</label>
                <textarea name="chuan_dau_ra" class="form-control" rows="3">{{ old('chuan_dau_ra', $nganhHoc->chuan_dau_ra) }}</textarea>
            </div>
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="trang_thai" name="trang_thai" value="1"
                        {{ old('trang_thai', $nganhHoc->trang_thai) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="trang_thai">Đang hoạt động</label>
                </div>
            </div>
            <a href="{{ route('admin.nganh-hoc.index') }}" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-warning">Cập nhật</button>
        </form>
    </div>
</div>
@endsection