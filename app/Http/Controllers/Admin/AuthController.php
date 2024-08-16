<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


class AuthController extends Controller
{
    public function login() {
        return response()->json(['status' => 200 , 'message' => 'Admin']);
    }
}