@extends('layouts.admin')

@section('title', 'Quản lý Học Phí')
@section('page_title', 'Quản lý Học Phí')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách Học Phí</h3>
        <div class="card-tools">
            <a href="{{ route('admin.hoc-phi.create') }}" class="btn btn-primary btn-sm">
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
                    <th>Ngành Học</th>
                    <th>Năm Học</th>
                    <th>Học phí/HK</th>
                    <th>Học phí/Tín chỉ</th>
                    <th>Ghi chú</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hocPhis as $hp)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $hp->nganhHoc->ten_nganh ?? '—' }}</td>
                    <td><span class="badge badge-info">{{ $hp->nam_hoc }}</span></td>
                    <td>{{ number_format($hp->hoc_phi_mot_hk) }} đ</td>
                    <td>{{ number_format($hp->hoc_phi_tin_chi) }} đ</td>
                    <td>{{ $hp->ghi_chu ?? '—' }}</td>
                    <td>
                        <a href="{{ route('admin.hoc-phi.edit', $hp->id) }}" class="btn btn-warning btn-xs">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('admin.hoc-phi.destroy', $hp->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Xóa học phí này?')">
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