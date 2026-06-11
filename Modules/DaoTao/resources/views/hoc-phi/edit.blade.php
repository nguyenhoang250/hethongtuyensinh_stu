@extends('layouts.admin')

@section('title', 'Sửa Học Phí')
@section('page_title', 'Sửa Học Phí')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sửa Học Phí</h3>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ route('admin.hoc-phi.update', $hocPhi->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Ngành Học <span class="text-danger">*</span></label>
                <select name="nganh_hoc_id" class="form-control">
                    <option value="">-- Chọn ngành --</option>
                    @foreach($nganhHocs as $nganh)
                        <option value="{{ $nganh->id }}" {{ old('nganh_hoc_id', $hocPhi->nganh_hoc_id) == $nganh->id ? 'selected' : '' }}>
                            {{ $nganh->ten_nganh }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Năm Học <span class="text-danger">*</span></label>
                <input type="text" name="nam_hoc" class="form-control" value="{{ old('nam_hoc', $hocPhi->nam_hoc) }}">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Học phí/Học kỳ (đồng) <span class="text-danger">*</span></label>
                        <input type="number" name="hoc_phi_mot_hk" class="form-control" value="{{ old('hoc_phi_mot_hk', $hocPhi->hoc_phi_mot_hk) }}" min="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Học phí/Tín chỉ (đồng) <span class="text-danger">*</span></label>
                        <input type="number" name="hoc_phi_tin_chi" class="form-control" value="{{ old('hoc_phi_tin_chi', $hocPhi->hoc_phi_tin_chi) }}" min="0">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Ghi chú</label>
                <input type="text" name="ghi_chu" class="form-control" value="{{ old('ghi_chu', $hocPhi->ghi_chu) }}">
            </div>
            <a href="{{ route('admin.hoc-phi.index') }}" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-warning">Cập nhật</button>
        </form>
    </div>
</div>
@endsection