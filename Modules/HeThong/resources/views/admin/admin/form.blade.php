@extends('layouts.admin')

@section('title', isset($admin) ? 'Sửa tài khoản' : 'Thêm tài khoản')
@section('page_title', isset($admin) ? 'Sửa tài khoản' : 'Thêm tài khoản')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ isset($admin) ? 'Cập nhật thông tin' : 'Tạo tài khoản mới' }}</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ isset($admin) ? route('admin.quan-ly.update', $admin) : route('admin.quan-ly.store') }}">
            @csrf
            @if(isset($admin)) @method('PUT') @endif

            {{-- Họ tên --}}
            <div class="form-group">
                <label>Họ tên <span class="text-danger">*</span></label>
                <input type="text" name="ho_ten"
                    value="{{ old('ho_ten', $admin->ho_ten ?? '') }}"
                    class="form-control {{ $errors->has('ho_ten') ? 'is-invalid' : '' }}"
                    placeholder="Nguyễn Văn A">
                @error('ho_ten')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label>Email <span class="text-danger">*</span></label>
                <input type="email" name="email"
                    value="{{ old('email', $admin->email ?? '') }}"
                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    placeholder="example@stu.edu.vn">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Số điện thoại --}}
            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" name="so_dien_thoai"
                    value="{{ old('so_dien_thoai', $admin->so_dien_thoai ?? '') }}"
                    class="form-control"
                    placeholder="0901234567">
            </div>

            {{-- Vai trò --}}
            <div class="form-group">
                <label>Vai trò <span class="text-danger">*</span></label>
                <select name="vai_tro" id="vai_tro"
                    class="form-control {{ $errors->has('vai_tro') ? 'is-invalid' : '' }}">
                    <option value="">-- Chọn vai trò --</option>
                    <option value="admin"
                        {{ old('vai_tro', $admin->vai_tro ?? '') === 'admin' ? 'selected' : '' }}>
                        Quản trị viên
                    </option>
                    <option value="nhan_vien_tu_van"
                        {{ old('vai_tro', $admin->vai_tro ?? '') === 'nhan_vien_tu_van' ? 'selected' : '' }}>
                        Nhân viên tư vấn
                    </option>
                </select>
                @error('vai_tro')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Mật khẩu --}}
            <div class="form-group">
                <label>Mật khẩu
                    {{ isset($admin) ? '(để trống nếu không đổi)' : '' }}
                    <span class="text-danger">{{ isset($admin) ? '' : '*' }}</span>
                </label>
                <input type="password" name="mat_khau"
                    class="form-control {{ $errors->has('mat_khau') ? 'is-invalid' : '' }}"
                    placeholder="Tối thiểu 8 ký tự">
                @error('mat_khau')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- ===== PHẦN NVTV — ẩn/hiện bằng JS ===== --}}
            <div id="nvtv-fields" style="display:none;">
                <hr>
                <h6 class="text-muted mb-3">
                    <i class="fas fa-id-badge mr-1"></i> Thông tin nhân viên tư vấn
                </h6>

                {{-- Mã nhân viên --}}
                <div class="form-group">
                    <label>Mã nhân viên <span class="text-danger">*</span></label>
                    <input type="text" name="ma_nhan_vien"
                        value="{{ old('ma_nhan_vien', $admin->nhanVienTuVan->ma_nhan_vien ?? '') }}"
                        class="form-control {{ $errors->has('ma_nhan_vien') ? 'is-invalid' : '' }}"
                        placeholder="VD: NV-001">
                    @error('ma_nhan_vien')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Phòng ban --}}
                <div class="form-group">
                    <label>Phòng ban <span class="text-danger">*</span></label>
                    <input type="text" name="phong_ban"
                        value="{{ old('phong_ban', $admin->nhanVienTuVan->phong_ban ?? '') }}"
                        class="form-control {{ $errors->has('phong_ban') ? 'is-invalid' : '' }}"
                        placeholder="Phòng Tư vấn Tuyển sinh">
                    @error('phong_ban')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Chuyên môn --}}
                <div class="form-group">
                    <label>Chuyên môn</label>
                    <input type="text" name="chuyen_mon"
                        value="{{ old('chuyen_mon', $admin->nhanVienTuVan->chuyen_mon ?? '') }}"
                        class="form-control"
                        placeholder="VD: Công nghệ thông tin, Kỹ thuật">
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i>
                {{ isset($admin) ? 'Cập nhật' : 'Tạo mới' }}
            </button>
            <a href="{{ route('admin.quan-ly.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Hủy
            </a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const vaiTroSelect = document.getElementById('vai_tro');
    const nvtvFields   = document.getElementById('nvtv-fields');

    function toggleNVTV() {
        nvtvFields.style.display = vaiTroSelect.value === 'nhan_vien_tu_van' ? 'block' : 'none';
    }

    // Chạy ngay khi load (để xử lý trường hợp edit hoặc validation fail)
    toggleNVTV();

    vaiTroSelect.addEventListener('change', toggleNVTV);
</script>
@endpush