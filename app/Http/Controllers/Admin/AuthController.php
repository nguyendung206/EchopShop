<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        if (Auth::guard('admin')->check()) {
            return view('admin.index');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            Session::put('admin', Auth::guard('admin')->user());
            flash()->success('Đăng nhập thành công');

            return redirect()->route('admin.index');
        } else {
            // Đăng nhập thất bại
            flash()->error('Đăng nhập thất bại');

            return redirect()->back()->with('error', 'Email hoặc mật khẩu không đúng.');
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        Session::flush();

        return redirect()->route('admin.login');
    }
}
