{{-- Modules/HeThong/resources/views/auth/quen-mat-khau.blade.php --}}
@extends('hethong::components.layouts.master')

@section('title', 'Quên mật khẩu — STU Tuyển Sinh')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md bg-white rounded-xl shadow-md p-8">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Quên mật khẩu</h1>
            <p class="text-sm text-gray-500 mt-1">Nhập email để nhận link đặt lại mật khẩu</p>
        </div>

        @if(session('status'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.quen-mat-khau') }}">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                        {{ $errors->has('email') ? 'border-red-400' : 'border-gray-300' }}"
                    placeholder="admin@stu.edu.vn" autofocus>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-sm transition">
                Gửi link đặt lại
            </button>

            <p class="text-center text-sm text-gray-500 mt-4">
                <a href="{{ route('admin.dang-nhap') }}" class="text-blue-600 hover:underline">
                    ← Quay lại đăng nhập
                </a>
            </p>
        </form>

    </div>
</div>
@endsection