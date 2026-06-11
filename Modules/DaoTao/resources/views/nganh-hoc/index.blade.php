@extends('layouts.admin')

@section('title', 'Quản lý Ngành Học')
@section('page_title', 'Quản lý Ngành Học')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách Ngành Học</h3>
        <div class="card-tools">
            <a href="{{ route('admin.nganh-hoc.create') }}" class="btn btn-primary btn-sm">
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
                    <th>Mã Ngành</th>
                    <th>Tên Ngành</th>
                    <th>Khoa</th>
                    <th>Trình độ</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nganhHocs as $nganh)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge badge-info">{{ $nganh->ma_nganh }}</span></td>
                    <td>
                        {{ $nganh->ten_nganh }}
                        @if($nganh->ten_nganh_en)
                            <br><small class="text-muted">{{ $nganh->ten_nganh_en }}</small>
                        @endif
                    </td>
                    <td>{{ $nganh->khoa->ten_khoa ?? '—' }}</td>
                    <td>
                        @if($nganh->trinh_do == 'dai_hoc')
                            <span class="badge badge-primary">Đại học</span>
                        @else
                            <span class="badge badge-secondary">Liên thông</span>
                        @endif
                    </td>
                    <td>{{ $nganh->thoi_gian_dao_tao }} năm</td>
                    <td>
                        @if($nganh->trang_thai)
                            <span class="badge badge-success">Hoạt động</span>
                        @else
                            <span class="badge badge-danger">Dừng</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.nganh-hoc.edit', $nganh->id) }}" class="btn btn-warning btn-xs">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('admin.nganh-hoc.destroy', $nganh->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Xóa ngành này?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-xs">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center">Chưa có dữ liệu</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection