@extends('layouts.admin')

@section('title', isset($toHopMon) ? 'Sửa Tổ Hợp Môn' : 'Thêm Tổ Hợp Môn')
@section('page_title', isset($toHopMon) ? 'Sửa Tổ Hợp Môn' : 'Thêm Tổ Hợp Môn')

@section('content')

{{-- Quay lại --}}
<div class="mb-3">
    <a href="{{ route('admin.nganh-hoc.to-hop-mon', $nganhHoc->id) }}"
       class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Quay lại tổ hợp môn
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            {{ isset($toHopMon) ? 'Sửa' : 'Thêm' }} tổ hợp môn —
            <span class="badge badge-info">{{ $nganhHoc->ma_nganh }}</span>
            {{ $nganhHoc->ten_nganh }}
        </h3>
    </div>
    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(isset($toHopMon))
            {{-- Form SỬA --}}
            <form action="{{ route('admin.nganh-hoc.to-hop-mon.update', [$nganhHoc->id, $toHopMon->id]) }}"
                  method="POST">
                @csrf @method('PUT')
        @else
            {{-- Form THÊM --}}
            <form action="{{ route('admin.nganh-hoc.to-hop-mon.store', $nganhHoc->id) }}"
                  method="POST">
                @csrf
        @endif

            <div class="form-group">
                <label>Mã tổ hợp <span class="text-danger">*</span></label>
                <input type="text" name="ma_to_hop" class="form-control"
                       value="{{ old('ma_to_hop', $toHopMon->ma_to_hop ?? '') }}"
                       placeholder="VD: A00, A01, D01">
                <small class="text-muted">Mã tổ hợp môn theo quy định Bộ GD&ĐT</small>
            </div>

            <div class="form-group">
                <label>Tên tổ hợp môn <span class="text-danger">*</span></label>
                <input type="text" name="ten_to_hop" class="form-control"
                       value="{{ old('ten_to_hop', $toHopMon->ten_to_hop ?? '') }}"
                       placeholder="VD: Toán, Vật lí, Hóa học">
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input"
                           id="is_chinh" name="is_chinh" value="1"
                           {{ old('is_chinh', $toHopMon->is_chinh ?? false) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_chinh">
                        Tổ hợp môn chính
                    </label>
                </div>
            </div>

            <a href="{{ route('admin.nganh-hoc.to-hop-mon', $nganhHoc->id) }}"
               class="btn btn-secondary">Hủy</a>
            <button type="submit" class="btn {{ isset($toHopMon) ? 'btn-warning' : 'btn-primary' }}">
                <i class="fas fa-save mr-1"></i>
                {{ isset($toHopMon) ? 'Cập nhật' : 'Lưu' }}
            </button>

        </form>
    </div>
</div>

@endsection