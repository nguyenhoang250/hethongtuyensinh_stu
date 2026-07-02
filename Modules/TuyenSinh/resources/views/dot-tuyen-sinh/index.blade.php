@extends('layouts.admin')
@section('title', 'Đợt Tuyển Sinh')
@section('page_title', 'Quản lý Đợt Tuyển Sinh')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách Đợt Tuyển Sinh</h3>
        <div class="card-tools">
            <a href="{{ route('admin.dot-tuyen-sinh.create') }}" class="btn btn-primary btn-sm">
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
                    <th>Mã Đợt</th>
                    <th>Tên Đợt</th>
                    <th>Năm Học</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dots as $dot)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge badge-info">{{ $dot->ma_dot }}</span></td>
                    <td>{{ $dot->ten_dot }}</td>
                    <td>{{ $dot->nam_hoc }}</td>
                    <td>
                        <small>{{ \Carbon\Carbon::parse($dot->ngay_bat_dau)->format('d/m/Y') }}</small>
                        —
                        <small>{{ \Carbon\Carbon::parse($dot->ngay_ket_thuc)->format('d/m/Y') }}</small>
                    </td>
                    <td>
                        @php
                            $badges = ['chuan_bi'=>'secondary','dang_mo'=>'success','da_dong'=>'danger','da_cong_bo'=>'primary'];
                            $labels = ['chuan_bi'=>'Chuẩn bị','dang_mo'=>'Đang mở','da_dong'=>'Đã đóng','da_cong_bo'=>'Đã công bố'];
                        @endphp
                        <span class="badge badge-{{ $badges[$dot->trang_thai] ?? 'secondary' }}">
                            {{ $labels[$dot->trang_thai] ?? $dot->trang_thai }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.dot-tuyen-sinh.edit', $dot->id) }}" class="btn btn-warning btn-xs">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('admin.dot-tuyen-sinh.destroy', $dot->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Xóa đợt này?')">
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