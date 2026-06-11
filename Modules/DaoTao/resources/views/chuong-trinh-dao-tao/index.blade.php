@extends('layouts.admin')

@section('title', 'Chương Trình Đào Tạo')
@section('page_title', 'Chương Trình Đào Tạo')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách Chương Trình Đào Tạo</h3>
        <div class="card-tools">
            <a href="{{ route('admin.chuong-trinh-dao-tao.create') }}" class="btn btn-primary btn-sm">
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
                    <th>Năm Ban Hành</th>
                    <th>Tổng Tín Chỉ</th>
                    <th>File</th>
                    <th>Hiển thị</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ctdts as $ctdt)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ctdt->nganhHoc->ten_nganh ?? '—' }}</td>
                    <td>{{ $ctdt->nam_ban_hanh }}</td>
                    <td>{{ $ctdt->tong_tin_chi }} TC</td>
                    <td>
                        <a href="{{ asset('storage/' . $ctdt->duong_dan_file) }}" target="_blank" class="btn btn-info btn-xs">
                            <i class="fas fa-file-pdf"></i> {{ $ctdt->ten_file }}
                        </a>
                    </td>
                    <td>
                        @if($ctdt->is_hien_thi)
                            <span class="badge badge-success">Hiện</span>
                        @else
                            <span class="badge badge-secondary">Ẩn</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.chuong-trinh-dao-tao.edit', $ctdt->id) }}" class="btn btn-warning btn-xs">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('admin.chuong-trinh-dao-tao.destroy', $ctdt->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Xóa chương trình này?')">
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