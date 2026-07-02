@extends('layouts.admin')
@section('title', 'Phương Thức Xét Tuyển')
@section('page_title', 'Phương Thức Xét Tuyển')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách Phương Thức Xét Tuyển</h3>
        <div class="card-tools">
            <a href="{{ route('admin.phuong-thuc-xt.create') }}" class="btn btn-primary btn-sm">
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
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session('error') }}
            </div>
        @endif
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Mã PT</th>
                    <th>Tên Phương Thức</th>
                    <th>Mô tả</th>
                    <th>Loại điểm</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($phuongThucs as $pt)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge badge-info">{{ $pt->ma_phuong_thuc }}</span></td>
                    <td>{{ $pt->ten_phuong_thuc }}</td>
                    <td>{{ $pt->mo_ta ? Str::limit($pt->mo_ta, 60) : '—' }}</td>
                    <td><span class="badge badge-warning">{{ $pt->loai_diem }}</span></td>
                    <td>
                        @if($pt->is_active)
                            <span class="badge badge-success">Hoạt động</span>
                        @else
                            <span class="badge badge-danger">Dừng</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.phuong-thuc-xt.edit', $pt->id) }}" class="btn btn-warning btn-xs">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('admin.phuong-thuc-xt.destroy', $pt->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Xóa phương thức này?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">Chưa có dữ liệu</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection