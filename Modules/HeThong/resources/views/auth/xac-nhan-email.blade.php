{{-- Modules/HeThong/resources/views/auth/xac-nhan-email.blade.php --}}
@extends('hethong::components.layouts.master')

@section('title', 'Xác nhận email — STU Tuyển Sinh')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md bg-white rounded-xl shadow-md p-8 text-center">

        <div class="text-5xl mb-4">📧</div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Xác nhận email</h1>
        <p class="text-sm text-gray-500 mb-6">
            Chúng tôi đã gửi email xác nhận đến địa chỉ của bạn.<br>
            Vui lòng kiểm tra hộp thư và nhấn vào link xác nhận.
        </p>

        @if(session('status'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('thi-sinh.xac-nhan-email') }}">
            @csrf
            <button type="submit"
                class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-sm transition">
                Gửi lại email xác nhận
            </button>
        </form>

        <form method="POST" action="{{ route('thi-sinh.dang-xuat') }}" class="mt-3">
            @csrf
            <button type="submit" class="text-sm text-gray-400 hover:text-gray-600">
                Đăng xuất
            </button>
        </form>

    </div>
</div>
@endsection