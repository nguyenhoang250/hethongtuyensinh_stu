@extends('layouts.admin')

@section('title', 'Quản lý Khoa')
@section('page_title', 'Quản lý Khoa')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách Khoa</h3>
        <div class="card-tools">
            <a href="{{ route('admin.khoa.create') }}" class="btn btn-primary btn-sm">
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
                    <th>Mã Khoa</th>
                    <th>Tên Khoa</th>
                    <th>Trưởng Khoa</th>
                    <th>Email</th>
                    <th>Thứ tự</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($khoas as $khoa)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge badge-info">{{ $khoa->ma_khoa }}</span></td>
                    <td>{{ $khoa->ten_khoa }}</td>
                    <td>{{ $khoa->truong_khoa ?? '—' }}</td>
                    <td>{{ $khoa->email_khoa ?? '—' }}</td>
                    <td>{{ $khoa->thu_tu }}</td>
                    <td>
                        <a href="{{ route('admin.khoa.edit', $khoa->id) }}" class="btn btn-warning btn-xs">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('admin.khoa.destroy', $khoa->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Xóa khoa này?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-xs">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
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