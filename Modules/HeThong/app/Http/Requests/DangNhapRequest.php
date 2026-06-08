<?php

namespace Modules\HeThong\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DangNhapRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'     => 'required|email|max:150',
            'mat_khau'  => 'required|string|min:8',
            'nho_toi'   => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'Vui lòng nhập email.',
            'email.email'       => 'Email không đúng định dạng.',
            'mat_khau.required' => 'Vui lòng nhập mật khẩu.',
            'mat_khau.min'      => 'Mật khẩu tối thiểu 8 ký tự.',
        ];
    }
}