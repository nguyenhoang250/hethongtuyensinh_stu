@extends('layouts.admin')

@section('title', 'Thêm Tổ Hợp Môn')
@section('page_title', 'Thêm Tổ Hợp Môn')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm Tổ Hợp Môn mới</h3>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ route('admin.to-hop-mon.store') }}" method="POST">
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
            <div class="form-group">
                <label>Mã Tổ Hợp <span class="text-danger">*</span></label>
                <input type="text" name="ma_to_hop" class="form-control" value="{{ old('ma_to_hop') }}" placeholder="VD: A00, D01">
            </div>
            <div class="form-group">
                <label>Tên Tổ Hợp <span class="text-danger">*</span></label>
                <input type="text" name="ten_to_hop" class="form-control" value="{{ old('ten_to_hop') }}" placeholder="VD: Toán – Lý – Hóa">
            </div>
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_chinh" name="is_chinh" value="1" {{ old('is_chinh') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_chinh">Tổ hợp chính</label>
                </div>
            </div>
            <a href="{{ route('admin.to-hop-mon.index') }}" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>
</div>
@endsection