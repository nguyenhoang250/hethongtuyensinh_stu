@extends('layouts.admin')

@section('title', 'Quản lý Tổ Hợp Môn')
@section('page_title', 'Quản lý Tổ Hợp Môn')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách Tổ Hợp Môn</h3>
        <div class="card-tools">
            <a href="{{ route('admin.to-hop-mon.create') }}" class="btn btn-primary btn-sm">
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
                    <th>Mã Tổ Hợp</th>
                    <th>Tên Tổ Hợp</th>
                    <th>Ngành Học</th>
                    <th>Chính</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($toHopMons as $toHop)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge badge-warning">{{ $toHop->ma_to_hop }}</span></td>
                    <td>{{ $toHop->ten_to_hop }}</td>
                    <td>{{ $toHop->nganhHoc->ten_nganh ?? '—' }}</td>
                    <td>
                        @if($toHop->is_chinh)
                            <span class="badge badge-success">Chính</span>
                        @else
                            <span class="badge badge-secondary">Phụ</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.to-hop-mon.edit', $toHop->id) }}" class="btn btn-warning btn-xs">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('admin.to-hop-mon.destroy', $toHop->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Xóa tổ hợp này?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-xs">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">Chưa có dữ liệu</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection