@extends('layouts.admin')

@section('title', 'Danh sách thí sinh')
@section('page_title', 'Danh sách thí sinh')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách thí sinh đăng ký</h3>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Số CCCD</th>
                    <th>Số điện thoại</th>
                    <th>Ngày sinh</th>
                    <th>Trường THPT</th>
                    <th>Đăng ký lúc</th>
                </tr>
            </thead>
            <tbody>
                @forelse($danhSach as $ts)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ts->ho_ten }}</td>
                    <td>{{ $ts->email }}</td>
                    <td>{{ $ts->so_cccd }}</td>
                    <td>{{ $ts->so_dien_thoai }}</td>
                    <td>{{ $ts->ngay_sinh?->format('d/m/Y') }}</td>
                    <td>{{ $ts->truong_thpt ?? '—' }}</td>
                    <td>{{ $ts->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center">Chưa có thí sinh nào</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $danhSach->links() }}
    </div>
</div>
@endsection