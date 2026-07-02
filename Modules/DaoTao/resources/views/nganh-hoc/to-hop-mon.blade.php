@extends('layouts.admin')

@section('title', 'Tổ Hợp Môn — ' . $nganhHoc->ten_nganh)
@section('page_title', 'Tổ Hợp Môn')

@section('content')

{{-- Quay lại --}}
<div class="mb-3">
    <a href="{{ route('admin.nganh-hoc.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách
    </a>
</div>

{{-- Thông tin ngành --}}
<div class="card mb-3">
    <div class="card-body">
        <h5 class="mb-1">
            <span class="badge badge-info">{{ $nganhHoc->ma_nganh }}</span>
            {{ $nganhHoc->ten_nganh }}
            @if($nganhHoc->ten_nganh_en)
                <small class="text-muted">— {{ $nganhHoc->ten_nganh_en }}</small>
            @endif
        </h5>
        <small class="text-muted">
            <i class="fas fa-building mr-1"></i>{{ $nganhHoc->khoa->ten_khoa ?? '—' }}
            &nbsp;·&nbsp;
            <i class="fas fa-clock mr-1"></i>{{ $nganhHoc->thoi_gian_dao_tao }} năm
        </small>
    </div>
</div>

{{-- Danh sách tổ hợp môn --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tổ Hợp Môn xét tuyển</h3>
        <div class="card-tools">
            <a href="{{ route('admin.nganh-hoc.to-hop-mon.create', $nganhHoc->id) }}"
               class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Thêm tổ hợp môn
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

        @if($toHopMons->isEmpty())
            <p class="text-center text-muted py-3">
                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                Ngành này chưa có tổ hợp môn nào.
            </p>
        @else
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Mã tổ hợp</th>
                        <th>Tên tổ hợp môn</th>
                        <th>Loại</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($toHopMons as $tohop)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge badge-primary">{{ $tohop->ma_to_hop }}</span></td>
                        <td>{{ $tohop->ten_to_hop }}</td>
                        <td>
                            @if($tohop->is_chinh)
                                <span class="badge badge-success">Chính</span>
                            @else
                                <span class="badge badge-secondary">Phụ</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.nganh-hoc.to-hop-mon.edit', [$nganhHoc->id, $tohop->id]) }}"
                               class="btn btn-warning btn-xs">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <form action="{{ route('admin.nganh-hoc.to-hop-mon.destroy', [$nganhHoc->id, $tohop->id]) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Xóa tổ hợp môn này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-xs">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
</div>

@endsection