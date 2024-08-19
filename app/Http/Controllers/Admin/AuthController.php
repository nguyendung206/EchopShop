<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'title' => 'Đăng nhập hệ thống'
        ]);
    }

    public function login(Request $request)
    {
        
    }
}
