@extends('layouts.admin')
@section('title', 'Sửa Chỉ Tiêu')
@section('page_title', 'Sửa Chỉ Tiêu Tuyển Sinh')
@section('content')
<div class="card">
    <div class="card-header"><h3 class="card-title">Sửa Chỉ Tiêu</h3></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ route('admin.chi-tieu.update', $chiTieu->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Đợt Tuyển Sinh <span class="text-danger">*</span></label>
                <select name="dot_tuyen_sinh_id" class="form-control">
                    <option value="">-- Chọn đợt --</option>
                    @foreach($dots as $dot)
                        <option value="{{ $dot->id }}" {{ old('dot_tuyen_sinh_id', $chiTieu->dot_tuyen_sinh_id) == $dot->id ? 'selected' : '' }}>
                            {{ $dot->ten_dot }} ({{ $dot->nam_hoc }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Ngành Học <span class="text-danger">*</span></label>
                <select name="nganh_hoc_id" class="form-control">
                    <option value="">-- Chọn ngành --</option>
                    @foreach($nganhs as $nganh)
                        <option value="{{ $nganh->id }}" {{ old('nganh_hoc_id', $chiTieu->nganh_hoc_id) == $nganh->id ? 'selected' : '' }}>
                            {{ $nganh->ten_nganh }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Phương Thức Xét Tuyển <span class="text-danger">*</span></label>
                <select name="phuong_thuc_id" class="form-control">
                    <option value="">-- Chọn phương thức --</option>
                    @foreach($phuongThucs as $pt)
                        <option value="{{ $pt->id }}" {{ old('phuong_thuc_id', $chiTieu->phuong_thuc_id) == $pt->id ? 'selected' : '' }}>
                            {{ $pt->ma_phuong_thuc }} - {{ $pt->ten_phuong_thuc }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Chỉ tiêu giao <span class="text-danger">*</span></label>
                        <input type="number" name="chi_tieu_giao" class="form-control" value="{{ old('chi_tieu_giao', $chiTieu->chi_tieu_giao) }}" min="1">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Đã tuyển</label>
                        <input type="number" name="chi_tieu_da_tuyen" class="form-control" value="{{ old('chi_tieu_da_tuyen', $chiTieu->chi_tieu_da_tuyen) }}" min="0">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Điểm chuẩn</label>
                        <input type="number" name="diem_chuan" class="form-control" value="{{ old('diem_chuan', $chiTieu->diem_chuan) }}" step="0.25" min="0">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Điểm sàn nộp HS</label>
                        <input type="number" name="diem_san_nop_hs" class="form-control" value="{{ old('diem_san_nop_hs', $chiTieu->diem_san_nop_hs) }}" step="0.25" min="0">
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.chi-tieu.index') }}" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-warning">Cập nhật</button>
        </form>
    </div>
</div>
@endsection