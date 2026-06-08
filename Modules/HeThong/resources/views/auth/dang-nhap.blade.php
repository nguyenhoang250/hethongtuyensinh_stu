{{-- Modules/HeThong/resources/views/auth/dang-nhap.blade.php --}}
@extends('hethong::components.layouts.master')

@section('title', 'Đăng nhập — STU Tuyển Sinh')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md bg-white rounded-xl shadow-md p-8">

        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-stu.png') }}" alt="STU" class="h-16 mx-auto mb-3">
            <h1 class="text-2xl font-bold text-gray-800">Đăng nhập</h1>
            <p class="text-sm text-gray-500 mt-1">Hệ thống Tuyển sinh STU</p>
        </div>

        @if(session('status'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.dang-nhap') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                        {{ $errors->has('email') ? 'border-red-400' : 'border-gray-300' }}"
                    placeholder="admin@stu.edu.vn" autofocus>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                <input type="password" name="mat_khau"
                    class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                        {{ $errors->has('mat_khau') ? 'border-red-400' : 'border-gray-300' }}"
                    placeholder="••••••••">
                @error('mat_khau')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                    <input type="checkbox" name="nho_toi" class="rounded">
                    Nhớ đăng nhập
                </label>
                <a href="{{ route('admin.quen-mat-khau') }}"
                    class="text-sm text-blue-600 hover:underline">
                    Quên mật khẩu?
                </a>
            </div>

            <button type="submit"
                class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-sm transition">
                Đăng nhập
            </button>
            <p class="text-center text-sm text-gray-500 mt-4">
    Chưa có tài khoản?
    
</p>
        </form>

    </div>
</div>
@endsection