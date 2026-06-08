<?php

namespace Modules\HeThong\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaoNguoiDungRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ho_ten'        => 'required|string|max:100',
            'email'         => 'required|email|max:150|unique:Admin,email',
            'mat_khau'      => 'required|string|min:8',
            'so_dien_thoai' => 'nullable|string|max:15',
            'anh_dai_dien'  => 'nullable|url|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'ho_ten.required'   => 'Vui lòng nhập họ tên.',
            'email.required'    => 'Vui lòng nhập email.',
            'email.unique'      => 'Email đã tồn tại trong hệ thống.',
            'mat_khau.required' => 'Vui lòng nhập mật khẩu.',
            'mat_khau.min'      => 'Mật khẩu tối thiểu 8 ký tự.',
        ];
    }
}