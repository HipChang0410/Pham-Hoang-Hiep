<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('web')->attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password'],
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.home'));
        }

        return back()->withErrors([
            'username' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function forgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    public function postForgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (! $user) {
            return back()->with('error', 'Email không tồn tại')->withInput();
        }

        $newPassword = Str::random(10);
        $user->password = Hash::make($newPassword);
        $user->save();

        Mail::send([], [], function ($message) use ($request, $newPassword): void {
            $message->to($request->email)
                ->subject('Đặt lại mật khẩu');
            $message->html('<h2>Mật khẩu mới của bạn là: '.$newPassword.'</h2><p>Vui lòng đổi mật khẩu sau khi đăng nhập.</p>');
        });

        return back()->with('message', 'Đã gửi mật khẩu mới. Bạn vui lòng kiểm tra email của bạn');
    }

    public function showChangePasswordForm()
    {
        return view('admin.auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (! $user || ! Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Mật khẩu hiện tại không đúng.',
            ]);
        }

        $user->password = Hash::make($data['new_password']);
        $user->save();

        return back()->with('status', 'Mật khẩu đã được thay đổi.');
    }
}
