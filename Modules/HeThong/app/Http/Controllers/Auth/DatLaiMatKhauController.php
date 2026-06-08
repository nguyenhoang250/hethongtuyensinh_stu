<?php

namespace Modules\HeThong\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class DatLaiMatKhauController extends Controller
{
    public function showQuenMatKhau()
    {
        return view('hethong::auth.quen-mat-khau');
    }

    public function guiLinkDatLai(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);

        Password::broker('admins')->sendResetLink(
            $request->only('email')
        );

        // Luôn trả về thành công để tránh email enumeration
        return back()->with('status', 'Nếu email tồn tại, chúng tôi đã gửi link đặt lại mật khẩu.');
    }

    public function showDatLai(string $token)
    {
        return view('hethong::auth.dat-lai-mat-khau', ['token' => $token]);
    }

    public function datLai(Request $request): RedirectResponse
    {
        $request->validate([
            'token'      => 'required',
            'email'      => 'required|email',
            'mat_khau'   => 'required|string|min:8|confirmed',
        ]);

        $status = Password::broker('admins')->reset(
            [
                'email'                 => $request->email,
                'password'              => $request->mat_khau,
                'password_confirmation' => $request->mat_khau_confirmation,
                'token'                 => $request->token,
            ],
            function ($user) use ($request) {
                $user->update(['mat_khau' => Hash::make($request->mat_khau)]);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('admin.dang-nhap')->with('status', 'Đặt lại mật khẩu thành công!');
        }

        return back()->withErrors(['email' => 'Link đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.']);
    }
}