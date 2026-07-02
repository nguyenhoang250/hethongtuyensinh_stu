@extends('layouts.admin')

@section('title', 'Thêm Học Phí')
@section('page_title', 'Thêm Học Phí')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm Học Phí mới</h3>
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
        <form action="{{ route('admin.hoc-phi.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Ngành Học <span class="text-danger">*</span></label>
                <select name="nganh_hoc_id" class="form-control">
                    <option value="">-- Chọn ngành --</option>
                    @foreach($nganhHocs as $nganh)
                        <option value="{{ $nganh->id }}"
                            {{ old('nganh_hoc_id') == $nganh->id ? 'selected' : '' }}>
                            [{{ $nganh->ma_nganh }}] {{ $nganh->ten_nganh }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Năm Học <span class="text-danger">*</span></label>
                <input type="text" name="nam_hoc" class="form-control"
                       value="{{ old('nam_hoc') }}"
                       placeholder="VD: 2025-2026">
                <small class="text-muted">Mỗi ngành chỉ được có 1 mức học phí cho mỗi năm học.</small>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Học phí/Học kỳ (đồng) <span class="text-danger">*</span></label>
                        <input type="number" name="hoc_phi_mot_hk" class="form-control"
                               value="{{ old('hoc_phi_mot_hk') }}"
                               min="0" placeholder="VD: 16500000">
                        <small class="text-muted" id="preview-hk"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Học phí/Tín chỉ (đồng) <span class="text-danger">*</span></label>
                        <input type="number" name="hoc_phi_tin_chi" class="form-control"
                               value="{{ old('hoc_phi_tin_chi') }}"
                               min="0" placeholder="VD: 550000">
                        <small class="text-muted" id="preview-tc"></small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Ghi chú</label>
                <input type="text" name="ghi_chu" class="form-control"
                       value="{{ old('ghi_chu') }}"
                       placeholder="VD: Áp dụng từ học kỳ 1 năm 2025">
            </div>
            <a href="{{ route('admin.hoc-phi.index') }}" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> Lưu
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview số tiền định dạng đẹp khi nhập
    function formatMoney(input, previewId) {
        document.getElementById(input).addEventListener('input', function () {
            const val = parseInt(this.value);
            const el  = document.getElementById(previewId);
            if (!isNaN(val) && val > 0) {
                el.textContent = '≈ ' + val.toLocaleString('vi-VN') + ' đồng';
                el.style.color = '#28a745';
            } else {
                el.textContent = '';
            }
        });
    }
    formatMoney('hoc_phi_mot_hk',  'preview-hk');
    formatMoney('hoc_phi_tin_chi', 'preview-tc');

    // Lấy id theo name vì dùng number input
    document.querySelector('[name=hoc_phi_mot_hk]').id  = 'hoc_phi_mot_hk';
    document.querySelector('[name=hoc_phi_tin_chi]').id = 'hoc_phi_tin_chi';
</script>
@endpush