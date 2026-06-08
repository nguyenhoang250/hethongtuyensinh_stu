@extends('layouts.admin')

@section('title', 'Quản lý Nhân viên tư vấn')
@section('page_title', 'Nhân viên tư vấn')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Danh sách nhân viên tư vấn</h3>
        <a href="{{ route('admin.nhan-vien-tu-van.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Thêm mới
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Họ tên</th>
                    <th>Mã NV</th>
                    <th>Email</th>
                    <th>Phòng ban</th>
                    <th>Chuyên môn</th>
                    <th>Số tư vấn</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($danhSach as $nv)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $nv->admin->ho_ten }}</td>
                    <td>{{ $nv->ma_nhan_vien }}</td>
                    <td>{{ $nv->admin->email }}</td>
                    <td>{{ $nv->phong_ban }}</td>
                    <td>{{ $nv->chuyen_mon ?? '—' }}</td>
                    <td>
                        <span class="badge badge-info">{{ $nv->so_luong_tu_van }}</span>
                    </td>
                    <td>
                        @if($nv->admin->trang_thai)
                            <span class="badge badge-success">Hoạt động</span>
                        @else
                            <span class="badge badge-danger">Bị khóa</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.nhan-vien-tu-van.edit', $nv) }}"
                            class="btn btn-sm btn-warning" title="Sửa">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.nhan-vien-tu-van.destroy', $nv) }}"
                            method="POST" class="d-inline"
                            onsubmit="return confirm('Xác nhận xóa nhân viên này?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-3">
                        <i class="fas fa-inbox mr-2"></i> Chưa có dữ liệu
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $danhSach->links() }}
    </div>
</div>
@endsection