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
        return view('admin.login');
    }

    public function Login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

    }
}
