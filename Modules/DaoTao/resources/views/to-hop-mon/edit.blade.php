@extends('layouts.admin')

@section('title', 'Sửa Tổ Hợp Môn')
@section('page_title', 'Sửa Tổ Hợp Môn')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sửa Tổ Hợp: {{ $toHopMon->ten_to_hop }}</h3>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ route('admin.to-hop-mon.update', $toHopMon->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Ngành Học <span class="text-danger">*</span></label>
                <select name="nganh_hoc_id" class="form-control">
                    <option value="">-- Chọn ngành --</option>
                    @foreach($nganhHocs as $nganh)
                        <option value="{{ $nganh->id }}" {{ old('nganh_hoc_id', $toHopMon->nganh_hoc_id) == $nganh->id ? 'selected' : '' }}>
                            {{ $nganh->ten_nganh }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Mã Tổ Hợp <span class="text-danger">*</span></label>
                <input type="text" name="ma_to_hop" class="form-control" value="{{ old('ma_to_hop', $toHopMon->ma_to_hop) }}">
            </div>
            <div class="form-group">
                <label>Tên Tổ Hợp <span class="text-danger">*</span></label>
                <input type="text" name="ten_to_hop" class="form-control" value="{{ old('ten_to_hop', $toHopMon->ten_to_hop) }}">
            </div>
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_chinh" name="is_chinh" value="1"
                        {{ old('is_chinh', $toHopMon->is_chinh) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_chinh">Tổ hợp chính</label>
                </div>
            </div>
            <a href="{{ route('admin.to-hop-mon.index') }}" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-warning">Cập nhật</button>
        </form>
    </div>
</div>
@endsection