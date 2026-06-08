@extends('layouts.admin')

@section('title', isset($nhanVienTuVan) ? 'Sửa NVTV' : 'Thêm NVTV')
@section('page_title', isset($nhanVienTuVan) ? 'Sửa nhân viên tư vấn' : 'Thêm nhân viên tư vấn')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ isset($nhanVienTuVan) ? 'Cập nhật thông tin' : 'Tạo mới' }}</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ isset($nhanVienTuVan) ? route('admin.nhan-vien-tu-van.update', $nhanVienTuVan) : route('admin.nhan-vien-tu-van.store') }}">
            @csrf
            @if(isset($nhanVienTuVan)) @method('PUT') @endif

            {{-- Thông tin tài khoản (lấy từ Admin) --}}
            <h5 class="mb-3 text-muted">Thông tin tài khoản</h5>

            <div class="form-group">
                <label>Họ tên <span class="text-danger">*</span></label>
                <input type="text" name="ho_ten"
                    value="{{ old('ho_ten', $nhanVienTuVan->admin->ho_ten ?? '') }}"
                    class="form-control {{ $errors->has('ho_ten') ? 'is-invalid' : '' }}"
                    placeholder="Nguyễn Văn A">
                @error('ho_ten')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Email đăng nhập <span class="text-danger">*</span></label>
                <input type="email" name="email"
                    value="{{ old('email', $nhanVienTuVan->admin->email ?? '') }}"
                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    placeholder="example@stu.edu.vn">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" name="so_dien_thoai"
                    value="{{ old('so_dien_thoai', $nhanVienTuVan->admin->so_dien_thoai ?? '') }}"
                    class="form-control"
                    placeholder="0901234567">
            </div>

            <div class="form-group">
                <label>Mật khẩu {{ isset($nhanVienTuVan) ? '(để trống nếu không đổi)' : '' }} <span class="text-danger">{{ isset($nhanVienTuVan) ? '' : '*' }}</span></label>
                <input type="password" name="mat_khau"
                    class="form-control {{ $errors->has('mat_khau') ? 'is-invalid' : '' }}"
                    placeholder="Tối thiểu 8 ký tự">
                @error('mat_khau')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <hr>

            {{-- Thông tin nhân viên --}}
            <h5 class="mb-3 text-muted">Thông tin nhân viên</h5>

            <div class="form-group">
                <label>Mã nhân viên <span class="text-danger">*</span></label>
                <input type="text" name="ma_nhan_vien"
                    value="{{ old('ma_nhan_vien', $nhanVienTuVan->ma_nhan_vien ?? '') }}"
                    class="form-control {{ $errors->has('ma_nhan_vien') ? 'is-invalid' : '' }}"
                    placeholder="VD: NV-001">
                @error('ma_nhan_vien')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Phòng ban <span class="text-danger">*</span></label>
                <input type="text" name="phong_ban"
                    value="{{ old('phong_ban', $nhanVienTuVan->phong_ban ?? '') }}"
                    class="form-control {{ $errors->has('phong_ban') ? 'is-invalid' : '' }}"
                    placeholder="Phòng Tư vấn Tuyển sinh">
                @error('phong_ban')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Chuyên môn</label>
                <input type="text" name="chuyen_mon"
                    value="{{ old('chuyen_mon', $nhanVienTuVan->chuyen_mon ?? '') }}"
                    class="form-control"
                    placeholder="VD: Công nghệ thông tin, Kỹ thuật">
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i>
                {{ isset($nhanVienTuVan) ? 'Cập nhật' : 'Tạo mới' }}
            </button>
            <a href="{{ route('admin.nhan-vien-tu-van.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Hủy
            </a>
        </form>
    </div>
</div>
@endsection