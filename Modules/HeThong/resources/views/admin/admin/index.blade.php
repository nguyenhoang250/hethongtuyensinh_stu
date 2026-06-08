@extends('layouts.admin')

@section('title', 'Quản lý Admin & Nhân viên tư vấn')
@section('page_title', 'Danh sách Admin & Nhân viên tư vấn')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Danh sách tài khoản</h3>
        <a href="{{ route('admin.quan-ly.create') }}" class="btn btn-primary btn-sm">
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
        @if($errors->has('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ $errors->first('error') }}
            </div>
        @endif

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Vai trò</th>
                    <th>Mã NV / Phòng ban</th>
                    <th>Trạng thái</th>
                    <th>Đăng nhập cuối</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($danhSach as $admin)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $admin->ho_ten }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->so_dien_thoai ?? '—' }}</td>
                    <td>
                        @if($admin->vai_tro === 'admin')
                            <span class="badge badge-danger">Quản trị viên</span>
                        @else
                            <span class="badge badge-info">Nhân viên tư vấn</span>
                        @endif
                    </td>
                    <td>
                        @if($admin->vai_tro === 'nhan_vien_tu_van' && $admin->nhanVienTuVan)
                            <div>
                                <small class="font-weight-bold text-primary">
                                    {{ $admin->nhanVienTuVan->ma_nhan_vien }}
                                </small>
                            </div>
                            <small class="text-muted">{{ $admin->nhanVienTuVan->phong_ban }}</small>
                            @if($admin->nhanVienTuVan->chuyen_mon)
                                <br>
                                <button class="btn btn-xs btn-outline-info mt-1"
                                    data-toggle="modal"
                                    data-target="#modal-nvtv-{{ $admin->id }}"
                                    title="Xem chi tiết">
                                    <i class="fas fa-eye"></i> Chi tiết
                                </button>
                            @endif
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($admin->trang_thai)
                            <span class="badge badge-success">Hoạt động</span>
                        @else
                            <span class="badge badge-secondary">Bị khóa</span>
                        @endif
                    </td>
                    <td>{{ $admin->lan_dang_nhap_cuoi?->format('d/m/Y H:i') ?? '—' }}</td>
                    <td>
                        <a href="{{ route('admin.quan-ly.edit', $admin) }}"
                            class="btn btn-sm btn-warning" title="Sửa">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.quan-ly.khoa', $admin) }}"
                            method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm {{ $admin->trang_thai ? 'btn-secondary' : 'btn-success' }}"
                                title="{{ $admin->trang_thai ? 'Khóa' : 'Mở khóa' }}">
                                <i class="fas fa-{{ $admin->trang_thai ? 'lock' : 'unlock' }}"></i>
                            </button>
                        </form>
                        @if($admin->id !== auth('admin')->id())
                        <form action="{{ route('admin.quan-ly.destroy', $admin) }}"
                            method="POST" class="d-inline"
                            onsubmit="return confirm('Xác nhận xóa tài khoản {{ $admin->ho_ten }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
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

{{-- ===== MODAL CHI TIẾT NVTV ===== --}}
@foreach($danhSach as $admin)
    @if($admin->vai_tro === 'nhan_vien_tu_van' && $admin->nhanVienTuVan)
    <div class="modal fade" id="modal-nvtv-{{ $admin->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-id-badge mr-2"></i>
                        Chi tiết nhân viên tư vấn
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted" style="width:40%">Họ tên</td>
                            <td><strong>{{ $admin->ho_ten }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email</td>
                            <td>{{ $admin->email }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Số điện thoại</td>
                            <td>{{ $admin->so_dien_thoai ?? '—' }}</td>
                        </tr>
                        <tr><td colspan="2"><hr class="my-2"></td></tr>
                        <tr>
                            <td class="text-muted">Mã nhân viên</td>
                            <td>
                                <span class="badge badge-primary">
                                    {{ $admin->nhanVienTuVan->ma_nhan_vien }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Phòng ban</td>
                            <td>{{ $admin->nhanVienTuVan->phong_ban }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Chuyên môn</td>
                            <td>{{ $admin->nhanVienTuVan->chuyen_mon ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Số lượng tư vấn</td>
                            <td>
                                <span class="badge badge-success">
                                    {{ $admin->nhanVienTuVan->so_luong_tu_van }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Trạng thái</td>
                            <td>
                                @if($admin->trang_thai)
                                    <span class="badge badge-success">Hoạt động</span>
                                @else
                                    <span class="badge badge-secondary">Bị khóa</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('admin.quan-ly.edit', $admin) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit mr-1"></i> Sửa thông tin
                    </a>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

@endsection