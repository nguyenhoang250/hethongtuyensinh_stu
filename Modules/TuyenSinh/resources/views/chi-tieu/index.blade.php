@extends('layouts.admin')
@section('title', 'Chỉ Tiêu Tuyển Sinh')
@section('page_title', 'Quản lý Chỉ Tiêu Tuyển Sinh')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách Chỉ Tiêu</h3>
        <div class="card-tools">
            <a href="{{ route('admin.chi-tieu.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Thêm mới
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Đợt Tuyển Sinh</th>
                    <th>Ngành Học</th>
                    <th>Phương Thức</th>
                    <th>Chỉ tiêu</th>
                    <th>Đã tuyển</th>
                    <th>Điểm chuẩn</th>
                    <th>Điểm sàn</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($chiTieus as $ct)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge badge-info">{{ $ct->dotTuyenSinh->ma_dot ?? '—' }}</span></td>
                    <td>{{ $ct->nganhHoc->ten_nganh ?? '—' }}</td>
                    <td>{{ $ct->phuongThuc->ma_phuong_thuc ?? '—' }}</td>
                    <td class="text-center"><strong>{{ $ct->chi_tieu_giao }}</strong></td>
                    <td class="text-center">{{ $ct->chi_tieu_da_tuyen }}</td>
                    <td class="text-center">
                        @if($ct->diem_chuan)
                            <span class="badge badge-success">{{ $ct->diem_chuan }}</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $ct->diem_san_nop_hs ?? '—' }}</td>
                    <td>
                        <a href="{{ route('admin.chi-tieu.edit', $ct->id) }}" class="btn btn-warning btn-xs">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('admin.chi-tieu.destroy', $ct->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Xóa chỉ tiêu này?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center">Chưa có dữ liệu</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection