{{-- Modules/HeThong/resources/views/auth/dat-lai-mat-khau.blade.php --}}
@extends('hethong::components.layouts.master')

@section('title', 'Đặt lại mật khẩu — STU Tuyển Sinh')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md bg-white rounded-xl shadow-md p-8">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Đặt lại mật khẩu</h1>
        </div>

        <form method="POST" action="{{ route('admin.dat-lai-mat-khau') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                        {{ $errors->has('email') ? 'border-red-400' : 'border-gray-300' }}"
                    placeholder="admin@stu.edu.vn">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu mới</label>
                <input type="password" name="mat_khau"
                    class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                        {{ $errors->has('mat_khau') ? 'border-red-400' : 'border-gray-300' }}"
                    placeholder="••••••••">
                @error('mat_khau')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Xác nhận mật khẩu</label>
                <input type="password" name="mat_khau_confirmation"
                    class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="••••••••">
            </div>

            <button type="submit"
                class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-sm transition">
                Đặt lại mật khẩu
            </button>
        </form>

    </div>
</div>
@endsection