<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function Index()
    {
        if (auth()->check()) {
            return view('admin.index');
        }

        return view('admin.login');
    }

    public function Login(Request $request)
    {
        $request->validate([
            'email' => 'required|email:filter',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $user = Admin::where('email', $email)->first();
        dd($user);
        if ($user) {
            if (Hash::check($password, $user->password)) {
                auth()->login($user);
                Session::put('admin', $user);
                return view('admin.index');
            } else {
                return redirect()->back()->with('error', 'Mật khẩu không đúng.');
            }
        } else {
            return redirect()->back()->with('error', 'Admin không tồn tại.');
        }
    }
}
